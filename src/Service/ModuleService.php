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

namespace AxeptiocookiesAddon\Service;

use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Model\Constant\WhiteListModules;
use AxeptiocookiesAddon\Repository\ModuleRepository;
use Context;
use Lcobucci\JWT\Exception;
use Module;
use PrestaShop\PrestaShop\Adapter\ServiceLocator;
use Tools;
use Translate;

class ModuleService
{
    /**
     * @var ModuleRepository
     */
    protected $moduleRepository;

    /**
     * @param ModuleRepository $moduleRepository
     */
    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    public function getModulesListByIdConfiguration($idConfiguration, $idShop = null, $isActive = null, $restrictBySelected = false)
    {
        $selectedModules = $this->getSelectedModulesListByIdConfiguration($idConfiguration);

        $modules = $this->moduleRepository->getAllModules(
            $idShop,
            $isActive,
            $restrictBySelected ? $selectedModules : null
        );

        foreach ($modules as &$module) {
            $module['image'] = $this->getModuleImageLink($module['name']);
            $module['checked'] = in_array($module['name'], $selectedModules);

            $iso = substr(Context::getContext()->language->iso_code, 0, 2);

            if ($iso == 'en') {
                $configFile = _PS_MODULE_DIR_ . $module['name'] . '/config.xml';
            } else {
                $configFile = _PS_MODULE_DIR_ . $module['name'] . '/config_' . $iso . '.xml';
            }

            $xmlExist = (file_exists($configFile));
            $need_new_config_file = !$xmlExist
                || @filemtime($configFile) < @filemtime(_PS_MODULE_DIR_ . $module['name'] . '/' . $module['name'] . '.php');

            if ($xmlExist) {
                libxml_use_internal_errors(true);
                $xmlModule = @simplexml_load_file($configFile);
                if (!$xmlModule) {
                    continue;
                }

                $file = _PS_MODULE_DIR_ . $module['name'] . '/' . Context::getContext()->language->iso_code . '.php';
                if (Tools::file_exists_cache($file) && include_once($file)) {
                    if (isset($_MODULE) && is_array($_MODULE)) {
                        $_MODULES = !empty($_MODULES) ? array_merge($_MODULES, $_MODULE) : $_MODULE;
                    }
                }

                $module['displayName'] = stripslashes(
                    Translate::getModuleTranslation((string)$xmlModule->name,
                        Module::configXmlStringFormat($xmlModule->displayName), (string)$xmlModule->name)
                );
                $module['description'] = stripslashes(
                    Translate::getModuleTranslation((string)$xmlModule->name,
                        Module::configXmlStringFormat($xmlModule->description), (string)$xmlModule->name));
                $module['authorUri'] = (isset($xmlModule->author_uri) && $xmlModule->author_uri)
                    ? stripslashes($xmlModule->author_uri)
                    : false;
                $module['tab'] = (isset($xmlModule->tab) && $xmlModule->tab)
                    ? stripslashes($xmlModule->tab)
                    : false;
            } else {
                if (class_exists($module['name'], false)) {
                    try {
                        /** @var Module $moduleObj */
                        $moduleObj = ServiceLocator::get($module['name']);
                        $module['displayName'] = stripslashes($moduleObj->displayName);
                        $module['description'] = stripslashes($moduleObj->description);
                        $module['authorUri'] = isset($module->author_uri)
                            ? stripslashes($module->author_uri)
                            : false;
                        $module['tab'] = isset($module->tab)
                            ? stripslashes($module->tab)
                            : false;
                    } catch (Exception $e) {
                        continue;
                    }
                }
            }
        }

        $this->skipModules($modules);

        usort($modules, function ($arr1, $arr2) {
            return $arr1['name'] > $arr2['name'];
        });

        return $modules;
    }

    public function getSelectedModulesListByIdConfiguration($idConfiguration)
    {
        $selectedModules = $this->moduleRepository->getSelectedModulesByIdConfiguration($idConfiguration);

        if (empty($selectedModules)) {
            return [];
        }

        return array_map(function ($module) {
            return $module['module_name'];
        }, $selectedModules);
    }

    public function getModuleImageLink($moduleName)
    {
        $images = glob(_PS_MODULE_DIR_ . $moduleName . '/logo.{jpg,png,gif}', GLOB_BRACE);
        foreach ($images as $image) {
            return Context::getContext()->link->getBaseLink() . 'modules/' . $moduleName . DIRECTORY_SEPARATOR . basename($image);
        }

        return null;
    }

    protected function skipModules(&$modules)
    {
        $modules = array_filter($modules, function ($module) {
            return !in_array($module['name'], WhiteListModules::ALWAYS_SKIP_MODULES);
        });
    }

    public function associateToModules($idObject, array $modules)
    {
        $result = $this->clearModules($idObject);

        foreach ($modules as $moduleName) {
            $moduleAssociation = new AxeptioModuleConfiguration();
            $moduleAssociation->id_axeptiocookies_configuration = (int)$idObject;
            $moduleAssociation->module_name = $moduleName;
            $result &= $moduleAssociation->save();
        }

        return $result;
    }

    /**
     * @param int $idObject
     *
     * @return bool
     */
    public function clearModules($idObject)
    {
        return $this->moduleRepository->clearModules($idObject);
    }
}
