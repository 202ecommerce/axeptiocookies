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

use AxeptiocookiesAddon\AxeptioBaseTestCase;
use AxeptiocookiesAddon\Cache\ProjectCache;
use AxeptiocookiesAddon\Service\HookService;
use AxeptiocookiesAddon\Utils\ServiceContainer;

class CommonHookTest extends AxeptioBaseTestCase
{
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
        set_error_handler(function () {
            return false;
        });
        global $_COOKIE;
        $_COOKIE[HookService::DEFAULT_COOKIE_NAME . '_fr'] = json_encode([
            HookService::PS_MODULE_PREFIX . 'ps_emailsubscription' => true,
        ]);
        $_COOKIE[HookService::DEFAULT_COOKIE_NAME . '_en'] = json_encode([
            HookService::PS_MODULE_PREFIX . 'ps_emailsubscription' => true,
        ]);

        $this->hookDispatcher->dispatch(
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
}
