<?php
/**
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

use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Model\Constant\WhiteListModules;
use Db;
use DbQuery;

class ModuleRepository
{
    public function getSelectedModulesByIdConfiguration($idConfiguration)
    {
        $query = new DbQuery();
        $query->select('module_name');
        $query->from(AxeptioModuleConfiguration::$definition['table']);
        $query->where('id_axeptiocookies_configuration = ' . (int) $idConfiguration);

        return Db::getInstance()->executeS($query);
    }

    public function getAllModules($idShop = null, $isActive = null, $selectedModules = null)
    {
        $query = new DbQuery();
        $query->select('DISTINCT m.*');
        $query->from('module', 'm');
        $query->innerJoin(
            'hook_module',
            'hm',
            'hm.id_module = m.id_module'
        );
        $query->innerJoin(
            'hook',
            'h',
            'h.id_hook = hm.id_hook'
        );

        $whiteListHooks = array_map(function ($hook) {
            return '"' . pSQL($hook) . '"';
        }, WhiteListModules::WHITE_LIST_HOOKS);

        $query->where('
                  h.name NOT LIKE "displayBackOffice%"
                  AND h.name NOT LIKE "displayAdmin%"
                  AND h.name NOT LIKE "action%"
                  AND h.name NOT IN (' . implode(', ', $whiteListHooks) . ')
        ');

        if (!is_null($idShop)) {
            $query->innerJoin(
                'module_shop',
                'ms',
                'ms.id_module = m.id_module'
            );
            $query->where('ms.id_shop = ' . (int) $idShop);
        }

        if (!is_null($isActive)) {
            $query->where('m.active = ' . (int) $isActive);
        }

        if (!is_null($selectedModules)) {
            $selectedModules = array_map(function ($module) {
                return '"' . pSQL($module) . '"';
            }, $selectedModules);
            if (empty($selectedModules)) {
                $query->where('FALSE');
            } else {
                $query->where('m.name IN (' . implode(', ', $selectedModules) . ')');
            }
        }

        return Db::getInstance()->executeS($query);
    }

    public function clearModules($idObject)
    {
        return Db::getInstance()->delete(
            AxeptioModuleConfiguration::$definition['table'],
            'id_axeptiocookies_configuration = ' . (int) $idObject
        );
    }
}
