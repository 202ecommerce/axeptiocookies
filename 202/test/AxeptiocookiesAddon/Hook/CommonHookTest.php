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
        $this->module = ServiceContainer::getInstance()->get('axeptiocookies');
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
