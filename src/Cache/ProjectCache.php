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

namespace AxeptiocookiesAddon\Cache;

use AxeptiocookiesClasslib\Utils\CacheStorage\CacheStorage;

class ProjectCache extends CacheStorage
{
    protected $expiry = 0;//604800;

    /**
     * @param CacheParams $key
     *
     * @return bool
     */
    public function isExpired($key)
    {
        return parent::isExpired($key->getParams());
    }

    /**
     * @param CacheParams $key
     * @param $content
     * @param array $params
     * @param array $optional
     */
    public function set($key, $content, $params = [], $optional = [])
    {
        parent::set(
            $key->getParams(),
            $content,
            array_merge($params, $key->getParams()),
            $optional
        );
    }

    /**
     * @param CacheParams $key
     *
     * @return bool
     */
    public function exist($key)
    {
        return parent::exist($key->getParams());
    }

    /**
     * @param CacheParams $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if ($key instanceof CacheParams) {
            $key = $key->getParams();
        }

        return parent::get($key);
    }

    /**
     * @param CacheParams $key
     */
    public function remove($key)
    {
        parent::remove($key->getParams());
    }
}
