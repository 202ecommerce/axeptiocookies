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

use AxeptiocookiesAddon\API\Request\AbstractRequest;
use AxeptiocookiesAddon\API\Request\ProjectRequest;
use AxeptiocookiesAddon\API\Response\Factory\ResponseFactory;
use AxeptiocookiesAddon\API\Response\Object\Project;
use AxeptiocookiesAddon\API\Response\ProjectResponse;

class Client
{
    /**
     * @var ResponseFactory
     */
    protected $responseFactory;

    /**
     * @param ResponseFactory $responseFactory
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param AbstractRequest $request
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function call($request)
    {
        if (function_exists('curl_init') == false) {
            return false;
        }

        $url = $request->getUrl();
        if (empty($url)) {
            return false;
        }
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            [
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POST => false,
                CURLOPT_HTTPHEADER => [
                    'cache-control: no-cache',
                ],
            ]
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $responseClass = $this->responseFactory->getResponseClass($request);
        if (empty($response)) {
            $response = new $responseClass([]);
        } else {
            $response = new $responseClass(json_decode($response, true));
        }

        return $response->getResponse();
    }
}
