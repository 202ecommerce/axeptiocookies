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

use AxeptiocookiesAddon\API\Response\Object\Configuration;
use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Model\EditConfigurationModel;
use AxeptiocookiesAddon\Model\ListConfigurationModel;
use AxeptiocookiesAddon\Repository\ConfigurationRepository;
use AxeptiocookiesAddon\Validator\ConfigurationValidator;
use Module;
use PrestaShopException;
use Validate;

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
     * @param ConfigurationRepository $configurationRepository
     * @param ProjectService $projectService
     * @param ModuleService $moduleService
     * @param ConfigurationValidator $configurationValidator
     * @param HookService $hookService
     */
    public function __construct(ConfigurationRepository $configurationRepository,
                                ProjectService $projectService,
                                ModuleService $moduleService,
                                ConfigurationValidator $configurationValidator,
                                HookService $hookService)
    {
        $this->configurationRepository = $configurationRepository;
        $this->projectService = $projectService;
        $this->moduleService = $moduleService;
        $this->configurationValidator = $configurationValidator;
        $this->hookService = $hookService;
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
            return !empty(Module::getModuleIdByName($moduleName));
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
     * @throws PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function deleteById($idConfiguration)
    {
        $configuration = new AxeptioConfiguration($idConfiguration);

        if (!Validate::isLoadedObject($configuration)) {
            throw new PrestaShopException(sprintf('Unable to find configuration with id %s', $idConfiguration));
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
        if (!Validate::isLoadedObject($moduleConfiguration)) {
            throw new PrestaShopException('Undefined configuration id');
        }
        $modules = $this->moduleService->getModulesListByIdConfiguration($idObject);

        $project = $this->projectService->getCookiesByProjectId($moduleConfiguration->id_project);

        $configuration = array_reduce($project->getConfigurations(), function ($carry, Configuration $item) use ($moduleConfiguration) {
            if ($item->getId() == $moduleConfiguration->id_configuration) {
                $carry = $item;
            }

            return $carry;
        });

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
            ->setProject($project);
    }
}
