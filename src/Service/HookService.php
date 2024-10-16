<?php
/**
 * Copyright since 2022 Axeptio
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to tech@202-ecommerce.com so we can send you a copy immediately.
 *
 * @author    202 ecommerce <tech@202-ecommerce.com>
 * @copyright 2022 Axeptio
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
 */

namespace AxeptiocookiesAddon\Service;

if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesAddon\Cache\CacheParams;
use AxeptiocookiesAddon\Cache\ProjectCache;
use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Model\Constant\TriggerGtmEventType;
use AxeptiocookiesAddon\Model\Integration\ConsentModel;
use AxeptiocookiesAddon\Model\Integration\IntegrationModel;
use AxeptiocookiesAddon\Model\Integration\StepModel;
use AxeptiocookiesAddon\Model\Integration\VendorModel;
use AxeptiocookiesAddon\Repository\ConfigurationRepository;

class HookService
{
    const DEFAULT_COOKIE_NAME = 'axeptio_cookies';

    const DEFAULT_COOKIE_AUTHORIZED_VENDORS = 'axeptio_authorized_vendors';

    const DEFAULT_COOKIE_ALL_VENDORS = 'axeptio_all_vendors';

    const PS_MODULE_PREFIX = '_ps_module_';

    /**
     * @var ProjectCache
     */
    protected $projectCache;

    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * @var ConfigurationRepository
     */
    protected $configurationRepository;

    /**
     * @var ModuleService
     */
    protected $moduleService;

    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * @param ProjectCache $projectCache
     * @param ProjectService $projectService
     * @param ConfigurationRepository $configurationRepository
     * @param ModuleService $moduleService
     * @param ImageService $imageService
     */
    public function __construct(
        ProjectCache $projectCache,
        ProjectService $projectService,
        ConfigurationRepository $configurationRepository,
        ModuleService $moduleService,
        ImageService $imageService
    ) {
        $this->projectCache = $projectCache;
        $this->projectService = $projectService;
        $this->configurationRepository = $configurationRepository;
        $this->moduleService = $moduleService;
        $this->imageService = $imageService;
    }

    public function getIntegrationModelFromContext()
    {
        $cacheParams = new CacheParams();
        $cacheParams->setIdLang(\Context::getContext()->language->id);
        $cacheParams->setIdShop(\Context::getContext()->shop->id);

        if ($this->projectCache->exist($cacheParams) && !$this->projectCache->isExpired($cacheParams)) {
            $cacheResult = $this->projectCache->get($cacheParams);

            return $cacheResult['content'];
        }

        $configurations = $this->configurationRepository->getConfigurationsByShopLang(
            $cacheParams->getIdShop(),
            $cacheParams->getIdLang()
        );

        if (empty($configurations)) {
            return null;
        }

        $axeptioConfiguration = new AxeptioConfiguration($configurations[0][AxeptioConfiguration::$definition['primary']]);
        if (!\Validate::isLoadedObject($axeptioConfiguration)) {
            return null;
        }

        $configuration = $this->projectService->getConfigurationByIdProjectConfiguration(
            $axeptioConfiguration->id_project,
            $axeptioConfiguration->id_configuration
        );

        if (empty($configuration)) {
            return null;
        }

        $vendors = $this->getVendorsFromContextByIdConfiguration($axeptioConfiguration->id_axeptiocookies_configuration);

        $integrationModel = new IntegrationModel();
        $integrationModel->setClientId($axeptioConfiguration->id_project);
        $integrationModel->setCookiesVersion(empty($configuration->getId()) ? null : $configuration->getName());
        $integrationModel->setTriggerGtmEvents(TriggerGtmEventType::transformToValue((int) $axeptioConfiguration->trigger_gtm_events));

        if (!empty($vendors)) {
            $stepModel = new StepModel();
            $stepModel->setMessage($axeptioConfiguration->message);
            $stepModel->setTitle($axeptioConfiguration->title);
            $stepModel->setSubTitle($axeptioConfiguration->subtitle);
            $stepModel->setVendors($vendors);
            $stepModel->setDisablePaint(empty($axeptioConfiguration->paint));
            $illustration = $this->imageService->getIllustration($axeptioConfiguration);
            if (!empty($illustration)) {
                $illustrationUrl = $this->imageService->getImageUrl($axeptioConfiguration->illustration, \Context::getContext()->shop->id);
                if (!empty($illustrationUrl)) {
                    $stepModel->setImage($illustrationUrl);
                }
            } elseif (!$axeptioConfiguration->has_illustration) {
                $stepModel->setImage(null);
            }
            $integrationModel->setModuleStep($stepModel);
        }
        if (!$axeptioConfiguration->is_consent_v2) {
            $integrationModel->setConsent(null);
        } else {
            $integrationModel->setConsent(
                (new ConsentModel())
                    ->setAnalyticsStorage($axeptioConfiguration->analytics_storage ? 'granted' : 'denied')
                    ->setAdStorage($axeptioConfiguration->ad_storage ? 'granted' : 'denied')
                    ->setAdPersonalization($axeptioConfiguration->ad_personalization ? 'granted' : 'denied')
                    ->setAdUserData($axeptioConfiguration->ad_user_data ? 'granted' : 'denied')
                    ->setPersonalizationStorage($axeptioConfiguration->personalization_storage ? 'granted' : 'denied')
                    ->setFunctionalityStorage($axeptioConfiguration->functionality_storage ? 'granted' : 'denied')
                    ->setSecurityStorage($axeptioConfiguration->security_storage ? 'granted' : 'denied')
            );
        }

        $this->projectCache->set($cacheParams, $integrationModel);

        return $integrationModel;
    }

    /**
     * @param int $idConfiguration
     *
     * @return array
     */
    protected function getVendorsFromContextByIdConfiguration($idConfiguration)
    {
        $idShop = \Context::getContext()->shop->id;
        $modules = $this->moduleService->getModulesListByIdConfiguration(
            (int) $idConfiguration,
            $idShop,
            true,
            true
        );
        $vendors = [];

        foreach ($modules as $module) {
            if (empty($module['name'])) {
                continue;
            }
            $vendor = new VendorModel();
            $vendor->setDescription(!empty($module['description']) ? $module['description'] : '');
            $vendor->setName(self::PS_MODULE_PREFIX . $module['name']);
            if (!empty($module['recommended']) && !empty($module['recommended']->getTitle()) && empty(\Context::getContext()->employee)) {
                $vendor->setTitle($module['recommended']->getTitle());
            } else {
                $vendor->setTitle(!empty($module['displayName']) ? $module['displayName'] : $module['name']);
            }
            $vendor->setType(!empty($module['tab']) ? $module['tab'] : '');
            if (!empty($module['image'])) {
                $vendor->setImage($module['image']);
            }
            $vendors[] = $vendor;
        }

        usort($vendors, function (VendorModel $vendor1, VendorModel $vendor2) {
            return $vendor1->getTitle() > $vendor2->getTitle();
        });

        return $vendors;
    }

    public function purgeCache()
    {
        return $this->projectCache->cleanCacheDirectory();
    }
}
