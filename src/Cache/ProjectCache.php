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

namespace AxeptiocookiesAddon\Cache;

use AxeptiocookiesAddon\Model\Integration\IntegrationModel;
use AxeptiocookiesClasslib\Utils\CacheStorage\CacheStorage;

class ProjectCache extends CacheStorage
{
    /**
     * @var int
     */
    protected $expiry = 604800;

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
     * @param IntegrationModel $content
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
