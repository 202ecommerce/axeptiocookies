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

namespace AxeptiocookiesAddon\Service;

use AxeptiocookiesAddon\Model\Constant\WhiteListModules;
use Context;
use Hook;

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
                if ($this->isPreloadedHook($hookItem['module'], Hook::getNameById($hookItem['id_hook']))) {
                    continue;
                }
                if ($hookItem['module'] == $moduleName) {
                    unset($hookList[$index]);
                    break;
                }
            }
        }

        return !empty($hookList) ? $hookList : false;
    }

    public function isEligibleHookName($hookName)
    {
        if (empty($hookName)) {
            return false;
        }

        $isNotDisplayBO = preg_match('/^((?!displayBackOffice.*).)*$/m', $hookName);
        $isNotDisplayAdmin = preg_match('/^((?!displayAdmin.*).)*$/m', $hookName);
        $isNotAction = preg_match('/^((?!action.*).)*$/m', $hookName);
        $isNotInWhiteList = !in_array(strtolower($hookName), WhiteListModules::getAllWhiteListHooks());

        return $isNotDisplayBO && $isNotDisplayAdmin && $isNotAction && $isNotInWhiteList;
    }

    public function clearContextRequestCache()
    {
        static::$contextModules = [];
    }

    public function isPreloadedHook($moduleName, $hookName)
    {
        $preloadedHooks = WhiteListModules::PRELOADED_MODULES_HOOKS;
        if (!isset($preloadedHooks[$moduleName])) {
            return false;
        }

        return in_array($hookName, $preloadedHooks[$moduleName]);
    }
}
