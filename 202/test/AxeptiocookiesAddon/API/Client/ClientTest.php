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
use AxeptiocookiesAddon\API\Response\Factory\ResponseFactory;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testCall()
    {
        $client = new Client(new ResponseFactory());
        $request = new ProjectRequest();
        $request->setIdProject('5c7ce02205f1c66c7dd0d078');
        $response = $client->call($request);

        $this->assertNotEmpty($response->getIdProject());
    }

    public function testCallNotValid()
    {
        $client = new Client(new ResponseFactory());
        $request = new ProjectRequest();
        $request->setIdProject('test');
        $response = $client->call($request);

        $this->assertEmpty($response->getIdProject());
    }

    public function testCallUrlEmpty()
    {
        $client = new Client(new ResponseFactory());
        $request = new ProjectRequest();
        $request->setIdProject('');
        $response = $client->call($request);

        $this->assertFalse($response);
    }
}
