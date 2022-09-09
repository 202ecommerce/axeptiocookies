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

namespace AxeptiocookiesAddon\Utils;

use PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer as Container;

class ServiceContainer
{
    private static $instance;

    private $container;

    final protected function __construct()
    {
        $this->container = new Container(
            'axeptiocookies',
            _PS_MODULE_DIR_ . 'axeptiocookies/'
        );
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a container.');
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function get($serviceName)
    {
        return $this->container->getService($serviceName);
    }

    public function getContainer()
    {
        return $this->container;
    }
}
