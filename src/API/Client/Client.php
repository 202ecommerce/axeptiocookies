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

namespace AxeptiocookiesAddon\API\Client;

use AxeptiocookiesAddon\API\Request\ProjectRequest;
use AxeptiocookiesAddon\API\Response\Object\Project;
use AxeptiocookiesAddon\API\Response\ProjectResponse;

class Client
{
    /**
     * @param ProjectRequest $request
     *
     * @return Project|bool
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

        $response = new ProjectResponse(json_decode($response, true));

        return $response->getResponse();
    }
}
