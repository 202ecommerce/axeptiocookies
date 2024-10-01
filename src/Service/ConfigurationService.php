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

use AxeptiocookiesAddon\API\Response\Object\Configuration;
use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Model\EditConfigurationModel;
use AxeptiocookiesAddon\Model\ListConfigurationModel;
use AxeptiocookiesAddon\Repository\ConfigurationRepository;
use AxeptiocookiesAddon\Validator\ConfigurationValidator;

class ConfigurationService
{
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
     * @var ConfigurationValidator
     */
    protected $configurationValidator;

    /**
     * @var HookService
     */
    protected $hookService;
    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * @param ConfigurationRepository $configurationRepository
     * @param ProjectService $projectService
     * @param ModuleService $moduleService
     * @param ConfigurationValidator $configurationValidator
     * @param HookService $hookService
     * @param ImageService $imageService
     */
    public function __construct(
        ConfigurationRepository $configurationRepository,
        ProjectService $projectService,
        ModuleService $moduleService,
        ConfigurationValidator $configurationValidator,
        HookService $hookService,
        ImageService $imageService
    ) {
        $this->configurationRepository = $configurationRepository;
        $this->projectService = $projectService;
        $this->moduleService = $moduleService;
        $this->configurationValidator = $configurationValidator;
        $this->hookService = $hookService;
        $this->imageService = $imageService;
    }

    public function createConfiguration(CreateConfigurationModel $configurationModel)
    {
        $this->configurationValidator->validateCreateConfiguration($configurationModel);

        $configuration = new AxeptioConfiguration();
        $configuration->id_project = $configurationModel->getIdProject();
        $configuration->id_configuration = $configurationModel->getIdConfiguration();
        $configuration->id_lang = $configurationModel->getIdLanguage();
        $configuration->message = $configurationModel->getMessage();
        $configuration->title = $configurationModel->getTitle();
        $configuration->subtitle = $configurationModel->getSubtitle();

        $result = $configuration->save();

        if (!$result) {
            return false;
        }

        $this->configurationRepository->clearShops($configuration->id);

        $configuration->associateTo($configurationModel->getIdShops());

        $modules = array_filter(array_keys($this->moduleService->getRecommendedModules()), function ($moduleName) {
            return !empty(\Module::getModuleIdByName($moduleName));
        });
        $this->moduleService->associateToModules($configuration->id, $modules);

        $this->hookService->purgeCache();

        return $configuration->id;
    }

    public function editConfiguration(EditConfigurationModel $configurationModel)
    {
        $this->configurationValidator->validateEditConfiguration($configurationModel);

        $configuration = new AxeptioConfiguration($configurationModel->getIdObject());
        $configuration->id_project = $configurationModel->getIdProject();
        $configuration->id_configuration = $configurationModel->getConfiguration()->getId();
        $configuration->id_lang = (int) $configurationModel->getLanguage()['id_lang'];
        $configuration->message = $configurationModel->getMessage();
        $configuration->title = $configurationModel->getTitle();
        $configuration->subtitle = $configurationModel->getSubtitle();
        $configuration->paint = $configurationModel->getPaint();
        $configuration->has_illustration = $configurationModel->hasIllustration();
        $configuration->trigger_gtm_events = (int) $configurationModel->getTriggerGtmEvents();

        if (!empty($configuration->illustration)) {
            $this->imageService->deleteImage($configuration->illustration);
        }
        if (!empty($configurationModel->getIllustration()) && $configurationModel->hasIllustration() && $configurationModel->hasPersonalizedIllustration()) {
            $configuration->illustration = $this->imageService->saveImage($configurationModel->getIllustration());
        }

        if ($configurationModel->getIsConsentV2()) {
            $configuration->is_consent_v2 = $configurationModel->getIsConsentV2();
            $configuration->analytics_storage = $configurationModel->getAnalyticsStorage();
            $configuration->ad_user_data = $configurationModel->getAdUserData();
            $configuration->ad_personalization = $configurationModel->getAdPersonalization();
            $configuration->ad_storage = $configurationModel->getAdStorage();
            $configuration->functionality_storage = $configurationModel->getFunctionalityStorage();
            $configuration->personalization_storage = $configurationModel->getPersonalizationStorage();
            $configuration->security_storage = $configurationModel->getSecurityStorage();
        } else {
            $configuration->is_consent_v2 = false;
            $configuration->analytics_storage = false;
            $configuration->ad_user_data = false;
            $configuration->ad_personalization = false;
            $configuration->ad_storage = false;
            $configuration->functionality_storage = false;
            $configuration->personalization_storage = false;
            $configuration->security_storage = false;
        }

        $result = $configuration->save();

        if (!$result) {
            return false;
        }

        $this->configurationRepository->clearShops($configuration->id);

        $configuration->associateTo(array_map(function ($shop) {
            return (int) $shop['id_shop'];
        }, $configurationModel->getShops()));

        $modules = array_filter($configurationModel->getModules(), function ($module) {
            return $module['checked'] == 'true';
        });

        $modules = array_map(function ($module) {
            return $module['name'];
        }, $modules);

        $result = $this->moduleService->associateToModules($configurationModel->getIdObject(), $modules);

        $this->hookService->purgeCache();

        return $result;
    }

    /**
     * @param int $idConfiguration
     *
     * @return bool
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function deleteById($idConfiguration)
    {
        $configuration = new AxeptioConfiguration($idConfiguration);

        if (!\Validate::isLoadedObject($configuration)) {
            throw new \PrestaShopException(sprintf('Unable to find configuration with id %s', $idConfiguration));
        }

        $result = $configuration->delete();
        $result &= $this->moduleService->clearModules($idConfiguration);

        $this->hookService->purgeCache();

        return (bool) $result;
    }

    public function getAll()
    {
        $configurations = $this->configurationRepository->getAll();

        if (empty($configurations)) {
            return [];
        }

        $listConfigurations = [];

        foreach ($configurations as $configuration) {
            $configurationObj = new AxeptioConfiguration($configuration[AxeptioConfiguration::$definition['primary']]);
            $configurationProject = $this->projectService->getConfigurationByIdProjectConfiguration(
                $configurationObj->id_project,
                $configurationObj->id_configuration
            );
            $listConfiguration = (new ListConfigurationModel())
                ->setIdLanguage($configurationObj->id_lang)
                ->setIdProject($configurationObj->id_project)
                ->setIdConfiguration($configurationObj->id_configuration)
                ->setConfiguration($configurationProject)
                ->setIdShops($configurationObj->getAssociatedShops())
                ->setIdObject($configurationObj->id);
            $listConfigurations[] = $listConfiguration;
        }

        return $listConfigurations;
    }

    /**
     * @param int $idObject
     *
     * @return EditConfigurationModel
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function getById($idObject)
    {
        $moduleConfiguration = new AxeptioConfiguration((int) $idObject);
        if (!\Validate::isLoadedObject($moduleConfiguration)) {
            throw new \PrestaShopException('Undefined configuration id');
        }
        $modules = $this->moduleService->getModulesListByIdConfiguration($idObject);

        $project = $this->projectService->getCookiesByProjectId($moduleConfiguration->id_project);

        $configuration = array_reduce($project->getConfigurations(), function ($carry, Configuration $item) use ($moduleConfiguration) {
            if ($item->getId() == $moduleConfiguration->id_configuration) {
                $carry = $item;
            }

            return $carry;
        });

        $illustration = $this->imageService->getIllustration($moduleConfiguration);

        return (new EditConfigurationModel())
            ->setIdObject((int) $idObject)
            ->setLanguage(\Language::getLanguage($moduleConfiguration->id_lang))
            ->setIdProject($moduleConfiguration->id_project)
            ->setMessage($moduleConfiguration->message)
            ->setTitle($moduleConfiguration->title)
            ->setSubtitle($moduleConfiguration->subtitle)
            ->setConfiguration($configuration)
            ->setShops(array_map(function ($idShop) {
                return \Shop::getShop($idShop);
            }, $moduleConfiguration->getAssociatedShops()))
            ->setModules($modules)
            ->setProject($project)
            ->setPaint((bool) $moduleConfiguration->paint)
            ->setHasIllustration((bool) $moduleConfiguration->has_illustration)
            ->setHasPersonalizedIllustration(!empty($illustration))
            ->setIllustration($this->imageService->getIllustration($moduleConfiguration))
            ->setIsConsentV2((bool) $moduleConfiguration->is_consent_v2)
            ->setAnalyticsStorage((bool) $moduleConfiguration->analytics_storage)
            ->setAdStorage((bool) $moduleConfiguration->ad_storage)
            ->setAdUserData((bool) $moduleConfiguration->ad_user_data)
            ->setAdPersonalization((bool) $moduleConfiguration->ad_personalization)
            ->setFunctionalityStorage((bool) $moduleConfiguration->functionality_storage)
            ->setPersonalizationStorage((bool) $moduleConfiguration->personalization_storage)
            ->setSecurityStorage((bool) $moduleConfiguration->security_storage)
            ->setTriggerGtmEvents((int) $moduleConfiguration->trigger_gtm_events);
    }
}
