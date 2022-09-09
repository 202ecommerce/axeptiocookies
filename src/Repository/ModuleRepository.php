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
