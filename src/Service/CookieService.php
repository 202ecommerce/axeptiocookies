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

namespace AxeptiocookiesAddon\Service;

use AxeptiocookiesAddon\Model\Constant\WhiteListModules;
use Context;

class CookieService
{
    protected static $contextModules = [];

    /**
     * @var HookService
     */
    protected $hookService;

    /**
     * @param HookService $hookService
     */
    public function __construct(HookService $hookService)
    {
        $this->hookService = $hookService;
    }

    public function getModulesFromContext()
    {
        $language = Context::getContext()->language;

        $cookieName = HookService::DEFAULT_COOKIE_NAME . '_' . $language->iso_code;

        if (!empty(static::$contextModules[$cookieName])) {
            return static::$contextModules[$cookieName];
        }

        if (empty($_COOKIE[$cookieName])) {
            $axeptioCookies = [];
        } else {
            $axeptioCookies = json_decode($_COOKIE[$cookieName], true);
        }

        $integrationModel = $this->hookService->getIntegrationModelFromContext();

        if (empty($integrationModel)
            || empty($integrationModel->getModuleStep())
            || empty($integrationModel->getModuleStep()->getVendors())) {
            return [];
        }

        $psModules = [];

        foreach ($axeptioCookies as $moduleName => $cookieValue) {
            if (strpos($moduleName, HookService::PS_MODULE_PREFIX) !== false) {
                $moduleName = str_replace(HookService::PS_MODULE_PREFIX, '', $moduleName);
                $psModules[$moduleName] = $cookieValue;
            }
        }

        $resultVendors = [];

        foreach ($integrationModel->getModuleStep()->getVendors() as $vendor) {
            $vendorModuleName = str_replace(HookService::PS_MODULE_PREFIX, '', $vendor->getName());

            if (isset($psModules[$vendorModuleName])) {
                $resultVendors[$vendorModuleName] = $psModules[$vendorModuleName];
            } else {
                $resultVendors[$vendorModuleName] = false;
            }
        }

        static::$contextModules[$cookieName] = $resultVendors;

        return static::$contextModules[$cookieName];
    }

    public function getModifiedHookExecList($hookList)
    {
        if (empty($hookList)) {
            return $hookList;
        }

        $cookieModules = $this->getModulesFromContext();
        foreach ($cookieModules as $moduleName => $isActive) {
            if ($isActive) {
                continue;
            }

            foreach ($hookList as $index => $hookItem) {
                if ($hookItem['module'] == $moduleName) {
                    unset($hookList[$index]);
                    break;
                }
            }
        }

        return $hookList;
    }

    public function isEligibleHookName($hookName)
    {
        if (empty($hookName)) {
            return false;
        }

        $isNotDisplayBO = preg_match('/^((?!displayBackOffice.*).)*$/m', $hookName);
        $isNotDisplayAdmin = preg_match('/^((?!displayAdmin.*).)*$/m', $hookName);
        $isNotAction = preg_match('/^((?!action.*).)*$/m', $hookName);
        $isNotInWhiteList = !(in_array($hookName, WhiteListModules::WHITE_LIST_HOOKS));

        return $isNotDisplayBO && $isNotDisplayAdmin && $isNotAction && $isNotInWhiteList;
    }

    public function clearContextRequestCache()
    {
        static::$contextModules = [];
    }
}
