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

namespace AxeptiocookiesAddon\Repository;

use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use Db;
use DbQuery;

class ConfigurationRepository
{
    public function clearShops($idConfiguration)
    {
        Db::getInstance()->delete(
            AxeptioConfiguration::$definition['table'] . '_shop',
            AxeptioConfiguration::$definition['primary'] . ' = ' . (int) $idConfiguration
        );
    }

    public function getAll()
    {
        $query = new DbQuery();
        $query->select(AxeptioConfiguration::$definition['primary']);
        $query->from(AxeptioConfiguration::$definition['table']);

        return Db::getInstance()->executeS($query);
    }

    public function getConfigurationsByShopLang($idShop, $idLang, $idObject = null)
    {
        $query = new DbQuery();
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

        return Db::getInstance()->executeS($query);
    }
}
