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

namespace AxeptiocookiesAddon\Model\Constant;

if (!defined('_PS_VERSION_')) {
    exit;
}

class WhiteListModules
{
    const ALWAYS_SKIP_MODULES = [
        'axeptiocookies',
    ];

    const WHITE_LIST_HOOKS = [
        'moduleRoutes',
        'additionalCustomerFormFields',
        'addWebserviceResources',
        'dashboardData',
        'dashboardZoneOne',
        'dashboardZoneTwo',
        'filterCategoryContent',
        'filterCmsCategoryContent',
        'filterCmsContent',
        'filterHtmlContent',
        'filterManufacturerContent',
        'filterProductContent',
        'filterProductSearch',
        'filterSupplierContent',
        'overrideMinimalPurchasePrice',
        'sendMailAlterTemplateVars',
        'termsAndConditions',
        'updateProduct',
        'validateCustomerFormFields',
    ];

    public static function getAllWhiteListHooks($lowerCase = true)
    {
        if (!$lowerCase) {
            return self::WHITE_LIST_HOOKS;
        }

        return array_map(function ($hook) {
            return strtolower($hook);
        }, self::WHITE_LIST_HOOKS);
    }
}
