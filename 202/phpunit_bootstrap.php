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
//$basedir = '/var/www/html/';
$basedir = '/home/denys/www/prestashop810.denys.tot/site/';
require_once $basedir . 'config/config.inc.php';

require_once 'test/AxeptiocookiesAddon/AxeptioBaseTestCase.php';

// init a default front controller with context, cart,
$_SERVER['REQUEST_METHOD'] = 'GET';
$controller = new FrontController();
$controller->ssl = false;
$controller->init();