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

namespace AxeptiocookiesAddon;

use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Hook\HookDispatcher;
use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Service\ConfigurationService;
use AxeptiocookiesAddon\Service\ModuleService;
use AxeptiocookiesAddon\Service\ProjectService;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use Module;
use PHPUnit\Framework\TestCase;

abstract class AxeptioBaseTestCase extends TestCase
{
    /**
     * @var HookDispatcher
     */
    protected $hookDispatcher;

    /**
     * @var ConfigurationService
     */
    protected $configurationService;

    /**
     * @var ModuleService
     */
    protected $moduleService;

    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * @var Module
     */
    protected $module;

    protected function setUp()
    {
        parent::setUp();
        $this->module = ServiceContainer::getInstance()->get('axeptiocookies.module');
        $this->hookDispatcher = new HookDispatcher($this->module);
        $this->configurationService = ServiceContainer::getInstance()->get(ConfigurationService::class);
        $this->moduleService = ServiceContainer::getInstance()->get(ModuleService::class);
        $this->projectService = ServiceContainer::getInstance()->get(ProjectService::class);
    }


    protected function createConfigurationFixtures()
    {
        $hook = [
            'id_hook' => \Hook::getIdByName('displayFooterBefore'),
            'module' => 'ps_emailsubscription',
            'id_module' => \Module::getModuleIdByName('ps_emailsubscription'),
        ];
        $createConfigurationModel = (new CreateConfigurationModel())
            ->setIdProject(getenv('TEST_ID_PROJECT'))
            ->setIdConfiguration(getenv('TEST_ID_CONFIGURATION'))
            ->setIdLanguage(1)
            ->setIdShops([1]);

        $createConfigurationId = $this->configurationService->createConfiguration($createConfigurationModel);
        $this->moduleService->associateToModules($createConfigurationId, [
            'ps_emailsubscription',
        ]);

        return [
            'hooks' => [$hook],
            'id' => $createConfigurationId,
        ];
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::truncateTables();
    }

    protected static function truncateTables()
    {
        \Db::getInstance()->delete(AxeptioConfiguration::$definition['table'], 1);
        \Db::getInstance()->delete(AxeptioModuleConfiguration::$definition['table'], 1);
    }
}