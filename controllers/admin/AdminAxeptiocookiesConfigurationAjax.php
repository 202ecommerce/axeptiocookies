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
if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Model\EditConfigurationModel;
use AxeptiocookiesAddon\Model\Response\ErrorResponse;
use AxeptiocookiesAddon\Model\Response\SuccessNotificationResponse;
use AxeptiocookiesAddon\Model\Response\SuccessResponse;
use AxeptiocookiesAddon\Service\ConfigurationService;
use AxeptiocookiesAddon\Service\HookService;
use AxeptiocookiesAddon\Service\ProjectService;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use AxeptiocookiesAddon\Validator\ConfigurationValidatorException;

class AdminAxeptiocookiesConfigurationAjaxController extends ModuleAdminController
{
    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * @var ConfigurationService
     */
    protected $configurationService;

    /**
     * @var HookService
     */
    protected $hookService;

    /**
     * @var int
     */
    public $multishop_context = 0;

    public function __construct()
    {
        parent::__construct();
        $this->projectService = ServiceContainer::getInstance()->get(ProjectService::class);
        $this->configurationService = ServiceContainer::getInstance()->get(ConfigurationService::class);
        $this->hookService = ServiceContainer::getInstance()->get(HookService::class);
    }

    public function displayAjaxGetCookiesByProjectId()
    {
        try {
            $idProject = Tools::getValue('idProject');
            $project = $this->projectService->getCookiesByProjectId($idProject);

            $response = (new SuccessResponse())
                ->setData($project);

            $this->ajaxDie(json_encode($response));
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Failed to load configurations', $this->controller_name));
            $this->ajaxDie(json_encode($response));
        }
    }

    public function displayAjaxGetListConfigurations()
    {
        try {
            $configurations = $this->configurationService->getAll();

            $response = (new SuccessResponse())
                ->setData($configurations);

            $this->ajaxDie(json_encode($response));
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Failed to load your configurations', $this->controller_name));

            $this->ajaxDie(json_encode($response));
        }
    }

    public function displayAjaxDeleteConfiguration()
    {
        try {
            $idConfiguration = (int) Tools::getValue('idObject');

            $deleteResult = $this->configurationService->deleteById($idConfiguration);

            if ($deleteResult) {
                $response = (new SuccessNotificationResponse())
                    ->setMessage($this->l('Your association successfully deleted', $this->controller_name));
                $this->ajaxDie(json_encode($response));
            } else {
                throw new PrestaShopException('Error while deleting');
            }
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Failed while deleting your configuration'));
            $this->ajaxDie(json_encode($response));
        }
    }

    public function displayAjaxCreateConfiguration()
    {
        try {
            $configuration = Tools::getValue('configuration');

            if (empty($configuration)) {
                throw new PrestaShopException('Parameter configuration is not valid');
            }

            $configurationModel = (new CreateConfigurationModel())
                ->setIdProject($configuration['idProject'])
                ->setIdConfiguration($configuration['idConfiguration'])
                ->setIdShops($configuration['idShops'])
                ->setIdLanguage($configuration['idLanguage'])
                ->setMessage($configuration['message'])
                ->setTitle($configuration['title'])
                ->setSubtitle($configuration['subtitle']);

            $result = $this->configurationService->createConfiguration($configurationModel);

            if ($result) {
                $response = (new SuccessNotificationResponse())
                    ->setMessage($this->l('Association is created successfully', $this->controller_name))
                    ->setData((int) $result);
                $this->ajaxDie(json_encode($response));
            } else {
                throw new PrestaShopException('Failed to create configuration');
            }
        } catch (ConfigurationValidatorException $e) {
            $response = (new ErrorResponse())
                ->setMessage($e->getMessage());
            $this->ajaxDie(json_encode($response));
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Failed to create configuration', $this->controller_name));
            $this->ajaxDie(json_encode($response));
        }
    }

    public function displayAjaxEditConfiguration()
    {
        try {
            $configuration = Tools::getValue('configuration');
            if (empty($configuration)) {
                throw new PrestaShopException('Parameter configuration is not valid');
            }

            $configurationArray = [
                'identifier' => $configuration['configuration']['id'],
                'name' => $configuration['configuration']['name'],
                'title' => $configuration['configuration']['title'],
                'language' => $configuration['configuration']['language'],
            ];

            $configurationModel = (new EditConfigurationModel())
                ->setIdObject($configuration['idObject'])
                ->setIdProject($configuration['idProject'])
                ->setConfiguration(
                    (new \AxeptiocookiesAddon\API\Response\Object\Configuration())
                        ->build($configurationArray)
                )
                ->setShops($configuration['shops'])
                ->setLanguage($configuration['language'])
                ->setModules($configuration['modules'])
                ->setMessage($configuration['message'])
                ->setTitle($configuration['title'])
                ->setSubtitle($configuration['subtitle'])
                ->setHasIllustration(!empty($configuration['has_illustration']) && $configuration['has_illustration'] == 'true')
                ->setPaint(!empty($configuration['paint']) && $configuration['paint'] == 'true')
                ->setIllustration(!empty($configuration['illustration'])
                    && !empty($configuration['has_illustration'])
                    && $configuration['has_illustration'] == 'true' ? $configuration['illustration'] : null)
                ->setIsConsentV2(!empty($configuration['is_consent_v2']) && $configuration['is_consent_v2'] == 'true')
                ->setAnalyticsStorage(!empty($configuration['analytics_storage']) && $configuration['analytics_storage'] == 'true')
                ->setAdStorage(!empty($configuration['ad_storage']) && $configuration['ad_storage'] == 'true')
                ->setAdUserData(!empty($configuration['ad_user_data']) && $configuration['ad_user_data'] == 'true')
                ->setAdPersonalization(!empty($configuration['ad_personalization']) && $configuration['ad_personalization'] == 'true')
            ;

            $result = $this->configurationService->editConfiguration($configurationModel);

            if ($result) {
                $response = (new SuccessNotificationResponse())
                    ->setMessage($this->l('Configuration saved successfully', $this->controller_name));
                $this->ajaxDie(json_encode($response));
            } else {
                throw new PrestaShopException('Failed to save configuration');
            }
        } catch (ConfigurationValidatorException $e) {
            $response = (new ErrorResponse())
                ->setMessage($e->getMessage());
            $this->ajaxDie(json_encode($response));
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Error occurred while editing your configuration'));
            $this->ajaxDie(json_encode($response));
        }
    }

    public function displayAjaxGetEditConfiguration()
    {
        try {
            $idObject = (int) Tools::getValue('idObject');

            if (empty($idObject)) {
                throw new PrestaShopException('Failed to load parameter id');
            }

            $editConfiguration = $this->configurationService->getById($idObject);

            $response = (new SuccessResponse())
                ->setData($editConfiguration);
            $this->ajaxDie(json_encode($response));
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Failed while retrieving configuration', $this->controller_name));
            $this->ajaxDie(json_encode($response));
        }
    }

    public function displayAjaxClearCache()
    {
        try {
            $clearCacheResult = $this->hookService->purgeCache();

            if ($clearCacheResult) {
                $response = (new SuccessNotificationResponse())
                    ->setMessage($this->l('All caches successfully purged', $this->controller_name));
                $this->ajaxDie(json_encode($response));
            } else {
                throw new PrestaShopException('Error while purging cache');
            }
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Failed while purging cache', $this->controller_name));
            $this->ajaxDie(json_encode($response));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function ajaxDie($value = null, $controller = null, $method = null)
    {
        header('Content-Type: application/json');
        parent::ajaxDie($value, $controller, $method);
    }
}
