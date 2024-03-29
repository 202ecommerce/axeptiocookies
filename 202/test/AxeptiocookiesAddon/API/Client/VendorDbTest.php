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

namespace AxeptiocookiesAddon\API\Client;

use AxeptiocookiesAddon\API\Request\ProjectRequest;
use AxeptiocookiesAddon\API\Request\VendorDbRequest;
use AxeptiocookiesAddon\API\Response\Factory\ResponseFactory;
use AxeptiocookiesAddon\API\Response\Object\Vendor;
use PHPUnit\Framework\TestCase;

class VendorDbTest extends TestCase
{
    public function testCall()
    {
        $client = new Client(new ResponseFactory());
        $request = new VendorDbRequest();
        $response = $client->call($request);

        $this->assertNotEmpty($response);
        $this->assertInstanceOf(Vendor::class, $response[0]);
        $this->assertNotNull($response[0]->getId());
        $this->assertNotNull($response[0]->getName());
        $this->assertNotNull($response[0]->getUrl());
        $this->assertNotNull($response[0]->getState());
        $this->assertNotNull($response[0]->isRequired());
    }
}
