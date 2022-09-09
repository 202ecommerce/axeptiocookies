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

namespace AxeptiocookiesAddon\Update;

use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use PHPUnit\Framework\TestCase;

class UpdateHandlerTest extends TestCase
{
    public function testCreateLangShopConfigurationFromParams()
    {
        /** @var UpdateHandler $updateHandler */
        $updateHandler = ServiceContainer::getInstance()->get(UpdateHandler::class);

        $result = $updateHandler->createLangShopConfigurationFromParams(
            '62500feea925ec04460954a9',
            'projet test module axeptio-fr',
            1,
            1
        );

        $this->assertNotEmpty($result);
    }

    public function testCreateLangShopConfigurationFromParamsEmptyShop()
    {
        /** @var UpdateHandler $updateHandler */
        $updateHandler = ServiceContainer::getInstance()->get(UpdateHandler::class);

        $result = $updateHandler->createLangShopConfigurationFromParams(
            '62500feea925ec04460954a9',
            'projet test module axeptio-fr',
            null,
            1
        );

        $this->assertEmpty($result);
    }

    public function testCreateLangShopConfigurationFromParamsProjectIdNotValid()
    {
        /** @var UpdateHandler $updateHandler */
        $updateHandler = ServiceContainer::getInstance()->get(UpdateHandler::class);

        $result = $updateHandler->createLangShopConfigurationFromParams(
            'test',
            'projet test module axeptio-fr',
            1,
            1
        );

        $this->assertEmpty($result);
    }

    public function testCreateLangShopConfigurationFromParamsVersionNotValid()
    {
        /** @var UpdateHandler $updateHandler */
        $updateHandler = ServiceContainer::getInstance()->get(UpdateHandler::class);

        $result = $updateHandler->createLangShopConfigurationFromParams(
            '62500feea925ec04460954a9',
            'unknown',
            1,
            1
        );

        $this->assertEmpty($result);
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::truncateTables();
    }

    private static function truncateTables()
    {
        \Db::getInstance()->delete(AxeptioConfiguration::$definition['table'], 1);
        \Db::getInstance()->delete(AxeptioModuleConfiguration::$definition['table'], 1);
    }
}
