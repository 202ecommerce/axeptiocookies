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

namespace AxeptiocookiesAddon\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesAddon\Entity\AxeptioConfiguration;

class ConfigurationRepository
{
    public function clearShops($idConfiguration)
    {
        \Db::getInstance()->delete(
            AxeptioConfiguration::$definition['table'] . '_shop',
            AxeptioConfiguration::$definition['primary'] . ' = ' . (int) $idConfiguration
        );
    }

    public function getAll()
    {
        $query = new \DbQuery();
        $query->select(AxeptioConfiguration::$definition['primary']);
        $query->from(AxeptioConfiguration::$definition['table']);

        return \Db::getInstance()->executeS($query);
    }

    public function getConfigurationsByShopLang($idShop, $idLang, $idObject = null)
    {
        $query = new \DbQuery();
        $query->select('ac.' . AxeptioConfiguration::$definition['primary']);
        $query->from(AxeptioConfiguration::$definition['table'], 'ac');
        $query->innerJoin(
            AxeptioConfiguration::$definition['table'] . '_shop',
            'acs',
            'ac.id_axeptiocookies_configuration = acs.id_axeptiocookies_configuration'
        );
        $query->where('ac.id_lang = ' . (int) $idLang);
        $query->where('acs.id_shop = ' . (int) $idShop);

        if (!is_null($idObject)) {
            $query->where('ac.id_axeptiocookies_configuration <> ' . (int) $idObject);
        }

        return \Db::getInstance()->executeS($query);
    }
}
