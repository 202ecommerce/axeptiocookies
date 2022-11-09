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

use AxeptiocookiesAddon\AxeptioBaseTestCase;
use AxeptiocookiesAddon\Utils\ServiceContainer;

class CookieServiceTest extends AxeptioBaseTestCase
{

    /**
     * @var CookieService
     */
    protected $cookieService;

    /**
     * @var HookService
     */
    protected $hookService;

    public function setUp()
    {
        parent::setUp();
        $this->cookieService = ServiceContainer::getInstance()->get(CookieService::class);
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
}
