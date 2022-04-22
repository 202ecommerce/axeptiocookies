<?php
/*
 * NOTICE OF LICENSE
 *
 * This source file is subject to a commercial license from SARL 202 ecommerce
 * Use, copy, modification or distribution of this source file without written
 * license agreement from the SARL 202 ecommerce is strictly forbidden.
 * In order to obtain a license, please contact us: tech@202-ecommerce.com
 * ...........................................................................
 * INFORMATION SUR LA LICENCE D'UTILISATION
 *
 * L'utilisation de ce fichier source est soumise a une licence commerciale
 * concedee par la societe 202 ecommerce
 * Toute utilisation, reproduction, modification ou distribution du present
 * fichier source sans contrat de licence ecrit de la part de la SARL 202 ecommerce est
 * expressement interdite.
 * Pour obtenir une licence, veuillez contacter 202-ecommerce <tech@202-ecommerce.com>
 * ...........................................................................
 *
 * @author    202-ecommerce <tech@202-ecommerce.com>
 * @copyright Copyright (c) 202-ecommerce
 * @license   Commercial license
 */

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
     *
     */
    protected $hookService;

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
                ->setMessage($this->l('Failed to load configurations'));
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
                ->setMessage($this->l('Failed to load your configurations'));

            $this->ajaxDie(json_encode($response));
        }
    }

    public function displayAjaxDeleteConfiguration()
    {
        try {
            $idConfiguration = Tools::getValue('idObject');

            $deleteResult = $this->configurationService->deleteById($idConfiguration);

            if ($deleteResult) {
                $response = (new SuccessNotificationResponse())
                    ->setMessage($this->l('Your association successfully deleted'));
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
                    ->setMessage('Association is created successfully')
                    ->setData((int)$result);
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
                ->setMessage('Failed to create configuration');
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
                ->setSubtitle($configuration['subtitle']);

            $result = $this->configurationService->editConfiguration($configurationModel);

            if ($result) {
                $response = (new SuccessNotificationResponse())
                    ->setMessage($this->l('Configuration saved successfully'));
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
            $idObject = Tools::getValue('idObject');

            if (empty($idObject)) {
                throw new PrestaShopException('Failed to load parameter id');
            }

            $editConfiguration = $this->configurationService->getById($idObject);

            $response = (new SuccessResponse())
                ->setData($editConfiguration);
            $this->ajaxDie(json_encode($response));
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Failed while retrieving configuration'));
            $this->ajaxDie(json_encode($response));
        }
    }

    public function displayAjaxClearCache()
    {
        try {
            $clearCacheResult = $this->hookService->purgeCache();

            if ($clearCacheResult) {
                $response = (new SuccessNotificationResponse())
                    ->setMessage($this->l('All caches successfully purged'));
                $this->ajaxDie(json_encode($response));
            } else {
                throw new PrestaShopException('Error while purging cache');
            }
        } catch (Exception $e) {
            $response = (new ErrorResponse())
                ->setMessage($this->l('Failed while purging cache'));
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
