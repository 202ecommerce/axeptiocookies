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

namespace AxeptiocookiesAddon\Utils;

use AxeptiocookiesClasslib\Extensions\AbstractModuleExtension;
use AxeptiocookiesClasslib\Hook\AbstractHookDispatcher;
use AxeptiocookiesClasslib\Install\ModuleInstaller;
use Configuration;
use Context;
use Language;
use OrderState;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use ReflectionClass;
use Tools;

trait ModuleTrait
{
    // region Fields

    /**
     * List of hooks used in this Module
     *
     * @var array
     */
    public $hooks = [];

    /**
     * @var AbstractHookDispatcher
     */
    protected $hookDispatcher = null;

    /**
     * @var string
     */
    public $secure_key;

    /**
     * @var array
     */
    public $cronTasks = [];

    public $extensions = [];

    // endregion

    /**
     * Module constructor.
     */
    public function __construct()
    {
        parent::__construct();
        foreach ($this->extensions as $extensionName) {
            /** @var AbstractModuleExtension $extension */
            $extension = new $extensionName();
            $extension->setModule($this);
            $extension->initExtension();
            $this->hooks = array_merge($this->hooks, $extension->hooks);
        }
    }

    /**
     * Install Module
     *
     * @return bool
     *
     * @throws \PrestaShopException
     */
    public function install()
    {
        $installer = new ModuleInstaller($this);

        $isPhpVersionCompliant = false;

        try {
            $isPhpVersionCompliant = $installer->checkPhpVersion();
        } catch (\Exception $e) {
            $this->_errors[] = Tools::displayError($e->getMessage());
        }

        return $isPhpVersionCompliant && parent::install() && $installer->install();
    }

    /**
     * Uninstall Module
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function uninstall()
    {
        $installer = new ModuleInstaller($this);

        return parent::uninstall() && $installer->uninstall();
    }

    /**
     * @TODO Reset Module only if merchant choose to keep data on modal
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function reset()
    {
        $installer = new ModuleInstaller($this);

        return $installer->reset($this);
    }

    /**
     * Handle module extension hook call
     *
     * @param string $hookName
     * @param array $params
     *
     * @return array|bool|string
     */
    public function handleExtensionsHook($hookName, $params)
    {
        $result = false;
        $hookDispatcher = $this->getHookDispatcher();

        // execute module hooks
        if ($hookDispatcher != null) {
            $moduleHookResult = $hookDispatcher->dispatch($hookName, $params);
            if ($moduleHookResult != null) {
                $result = $moduleHookResult;
            }
        }

        // execute extension's hooks
        if (!isset($this->extensions) || empty($this->extensions)) {
            if (!$result) {
                return false;
            }
        }

        foreach ($this->extensions as $extension) {
            /** @var AbstractModuleExtension $extension */
            $extension = new $extension($this);
            $hookResult = null;
            if (is_callable([$extension, $hookName])) {
                $hookResult = $extension->{$hookName}($params);
            } elseif (is_callable([$extension, 'getHookDispatcher']) && $extension->getHookDispatcher() != null) {
                $hookResult = $extension->getHookDispatcher()->dispatch($hookName, $params);
            }
            if ($hookResult != null) {
                if ($result === false) {
                    $result = $hookResult;
                } elseif (is_array($hookResult) && $result !== false) {
                    $result = array_merge($result, $hookResult);
                } else {
                    $result .= $hookResult;
                }
            }
        }

        return $result;
    }

    /**
     * Handle module widget call
     *
     * @param string $action
     * @param string $method
     * @param string $hookName
     * @param array $configuration
     *
     * @return bool
     *
     * @throws \ReflectionException
     *
     * @deprecated use render widget function
     */
    public function handleWidget($action, $method, $hookName, $configuration)
    {
        if (!isset($this->extensions) || empty($this->extensions)) {
            return false;
        }

        foreach ($this->extensions as $extension) {
            /** @var AbstractModuleExtension $extension */
            $extension = new $extension();
            if (!($extension instanceof WidgetInterface)) {
                continue;
            }
            $extensionClass = (new ReflectionClass($extension))->getShortName();
            if ($extensionClass != $action) {
                continue;
            }
            $extension->setModule($this);
            if (is_callable([$extension, $method])) {
                return $extension->{$method}($hookName, $configuration);
            }
        }

        return false;
    }

    /**
     * @param string $hookName
     * @param array $configuration
     *
     * @return bool
     *
     * @throws \ReflectionException
     */
    public function renderWidget($hookName, array $configuration)
    {
        $hookDispatcher = $this->getHookDispatcher();
        // render module widgets
        if ($hookDispatcher != null) {
            $moduleWidgetResult = $hookDispatcher->dispatch($hookName, $configuration);
            if ($moduleWidgetResult != null) {
                return $moduleWidgetResult;
            }
        }

        // render extensions widget if module widget isn't found
        if (!isset($this->extensions) || empty($this->extensions)) {
            return false;
        }

        foreach ($this->extensions as $extension) {
            /** @var AbstractModuleExtension $extension */
            $extension = new $extension($this);

            if (is_callable([$extension, 'getHookDispatcher']) && $extension->getHookDispatcher() != null) {
                $extensionWidgetResult = $extension->getHookDispatcher()->dispatch($hookName, $configuration);
                if (is_null($extensionWidgetResult)) {
                    continue;
                }

                return $extensionWidgetResult;
            }
        }

        // if we want to use an old approach
        return $this->handleWidget($configuration['action'], __FUNCTION__, $hookName, $configuration);
    }

    /**
     * @param string $hookName
     * @param array $configuration
     *
     * @return array|bool
     */
    public function getWidgetVariables($hookName, array $configuration)
    {
        return [];
    }

    /**
     * Get the current module hook/widget dispatcher
     *
     * @return AbstractHookDispatcher|null
     */
    public function getHookDispatcher()
    {
        return $this->hookDispatcher;
    }

    /**
     * @return string|null
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * Register Order State : create new order state for this module
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function registerOrderStates()
    {
        if (empty($this->statuses)) {
            return true;
        }

        $moduleName = $this->name;
        $orderStates = OrderState::getOrderStates(Context::getContext()->language->id);

        $moduleStatuses = array_filter($orderStates, function ($state) use ($moduleName) {
            return $state['module_name'] == $moduleName;
        });

        if (!empty($moduleStatuses)) {
            return true;
        }

        $result = true;
        foreach ($this->statuses as $configurationName => $orderStateParams) {
            $orderState = new OrderState();
            $allLanguages = Language::getLanguages(false);
            foreach ($orderStateParams as $key => $value) {
                if ($key === 'name' || $key === 'template') {
                    foreach ($allLanguages as $language) {
                        if (empty($value[$language['iso_code']])) {
                            $orderState->$key[$language['id_lang']] = $value['en'];
                        } else {
                            $orderState->$key[$language['id_lang']] = $value[$language['iso_code']];
                        }
                    }
                } elseif ($key !== 'logo' && property_exists($orderState, $key)) {
                    $orderState->$key = $value;
                }
            }
            $orderState->module_name = $this->name;
            $resultAdd = (bool) $orderState->save();
            if (empty($orderStateParams['logo']) === false && $resultAdd) {
                $destination = _PS_ROOT_DIR_ . '/img/os/' . (int) $orderState->id . '.gif';
                copy($orderStateParams['logo'], $destination);
            }
            $result &= $resultAdd;
            Configuration::updateValue($configurationName, $orderState->id);
        }

        return $result;
    }
}
