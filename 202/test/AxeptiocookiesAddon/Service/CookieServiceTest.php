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

use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use PHPUnit\Framework\TestCase;

class CookieServiceTest extends TestCase
{

    /**
     * @var CookieService
     */
    protected $cookieService;

    /**
     * @var ConfigurationService
     */
    protected $configurationService;

    /**
     * @var ModuleService
     */
    protected $moduleService;

    /**
     * @var HookService
     */
    protected $hookService;

    public function setUp()
    {
        parent::setUp();
        $this->cookieService = ServiceContainer::getInstance()->get(CookieService::class);
        $this->configurationService = ServiceContainer::getInstance()->get(ConfigurationService::class);
        $this->moduleService = ServiceContainer::getInstance()->get(ModuleService::class);
        $this->hookService = ServiceContainer::getInstance()->get(HookService::class);
    }

    public function testIsEligibleHookNameEmpty()
    {
        $result = $this->cookieService->isEligibleHookName('');

        $this->assertFalse($result);
    }

    public function testIsEligibleHookNameBO()
    {
        $result = $this->cookieService->isEligibleHookName('displayBackOfficeCategory');

        $this->assertFalse($result);
    }

    public function testIsEligibleHookNameFront()
    {
        $result = $this->cookieService->isEligibleHookName('displayBeforeBodyClosingTag');

        $this->assertTrue($result);
    }

    public function testGetModifiedHookExecListEmpty()
    {
        $result = $this->cookieService->getModifiedHookExecList([]);

        $this->assertEmpty($result);
    }

    public function testGetModifiedHookExecListDependency()
    {
        $this->truncateTables();
        $this->hookService->purgeCache();
        $data = $this->createConfigurationFixtures();

        $result = $this->cookieService->getModifiedHookExecList($data['hooks']);

        $this->assertEmpty($result);
    }

    public function testGetModifiedHookExecListDependencyTrue()
    {
        $this->truncateTables();
        $this->hookService->purgeCache();
        $data = $this->createConfigurationFixtures();

        global $_COOKIE;
        $_COOKIE[HookService::DEFAULT_COOKIE_NAME . '_' . \Language::getIsoById(1)] = json_encode([
            HookService::PS_MODULE_PREFIX . 'ps_emailsubscription' => true,
        ]);
        $this->cookieService->clearContextRequestCache();
        $result = $this->cookieService->getModifiedHookExecList($data['hooks']);

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

    private static function truncateTables()
    {
        \Db::getInstance()->delete(AxeptioConfiguration::$definition['table'], 1);
        \Db::getInstance()->delete(AxeptioModuleConfiguration::$definition['table'], 1);
    }
}
