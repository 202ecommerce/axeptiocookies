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
