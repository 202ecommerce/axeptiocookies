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

namespace AxeptiocookiesAddon\Hook;

use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Service\ConfigurationService;
use AxeptiocookiesAddon\Service\HookService;
use AxeptiocookiesAddon\Service\ModuleService;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use FrontController;
use Module;
use PHPUnit\Framework\TestCase;

class CommonHookTest extends TestCase
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
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::truncateTables();
    }

    public function testActionDispatcherBeforeFrontEmpty()
    {
        $result = $this->hookDispatcher->dispatch(
            'actionDispatcherBefore',
            [
                'controller_type' => \Dispatcher::FC_FRONT,
            ]
        );
        $this->assertEmpty($result);
    }

    public function testActionDispatcherBeforeFrontReplace()
    {
        set_error_handler(function ($error) {
            return false;
        });
        global $_COOKIE;
        $_COOKIE[HookService::DEFAULT_COOKIE_NAME] = json_encode([
            HookService::PS_MODULE_PREFIX . 'ps_emailsubscription' => true,
        ]);

        $result = $this->hookDispatcher->dispatch(
            'actionDispatcherBefore',
            [
                'controller_type' => \Dispatcher::FC_FRONT,
            ]
        );
        $this->assertEmpty($_COOKIE);
    }

    public function testActionDispatcherBeforeAdminEmpty()
    {
        $result = $this->hookDispatcher->dispatch(
            'actionDispatcherBefore',
            [
                'controller_type' => \Dispatcher::FC_ADMIN,
            ]
        );
        $this->assertEmpty($result);
    }

    public function testDisplayFooter()
    {
        self::truncateTables();
        $result = $this->hookDispatcher->dispatch('displayFooter');
        $this->assertEmpty($result);
    }

    public function testDisplayFooterFixtures()
    {
        $data = $this->createConfigurationFixtures();
        $result = $this->hookDispatcher->dispatch('displayFooter');
        $this->assertNotEmpty($result);
    }

    private function createConfigurationFixtures()
    {
        $hook = [
            'id_hook' => \Hook::getIdByName('displayFooterBefore'),
            'module' => 'ps_emailsubscription',
            'id_module' => \Module::getModuleIdByName('ps_emailsubscription'),
        ];
        $createConfigurationModel = (new CreateConfigurationModel())
            ->setIdProject('62500feea925ec04460954a9')
            ->setIdConfiguration('62500fefea9774f707035148')
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

    private static function truncateTables()
    {
        \Db::getInstance()->delete(AxeptioConfiguration::$definition['table'], 1);
        \Db::getInstance()->delete(AxeptioModuleConfiguration::$definition['table'], 1);
    }
}
