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

namespace AxeptiocookiesAddon\Update;

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
}
