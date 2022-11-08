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

use AxeptiocookiesAddon\AxeptioBaseTestCase;
use AxeptiocookiesAddon\Utils\ServiceContainer;

class UpdateHandlerTest extends AxeptioBaseTestCase
{
    const TEST_VERSION_ID = 'projet test module axeptio-fr';

    public function testCreateLangShopConfigurationFromParams()
    {
        /** @var UpdateHandler $updateHandler */
        $updateHandler = ServiceContainer::getInstance()->get(UpdateHandler::class);

        $result = $updateHandler->createLangShopConfigurationFromParams(
            getenv('TEST_ID_PROJECT'),
            self::TEST_VERSION_ID,
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
            getenv('TEST_ID_PROJECT'),
            self::TEST_VERSION_ID,
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
            self::TEST_VERSION_ID,
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
            getenv('TEST_ID_PROJECT'),
            'unknown',
            1,
            1
        );

        $this->assertEmpty($result);
    }
}
