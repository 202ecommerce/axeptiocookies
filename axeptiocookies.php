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

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_ . 'axeptiocookies/vendor/autoload.php';

use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Hook\HookDispatcher;
use AxeptiocookiesAddon\Utils\ModuleTrait;

class Axeptiocookies extends Module
{
    use ModuleTrait {
        ModuleTrait::__construct as private __mConstruct;
        ModuleTrait::install as private mInstall;
        ModuleTrait::uninstall as private mUninstall;
    }

    /** @var string This module requires at least PHP version */
    public $php_version_required = '5.6';

    /**
     * @var Context
     */
    public $context;

    /**
     * List of ModuleFrontController used in this Module
     * Module::install() register it, after that you can edit it in BO (for rewrite if needed)
     *
     * @var array
     */
    public $controllers = [
    ];

    /**
     * List of objectModel used in this Module
     *
     * @var array
     */
    public $objectModels = [
        AxeptioConfiguration::class,
        AxeptioModuleConfiguration::class,
    ];

    public $moduleAdminControllers = [
        [
            'name' => [
                'en' => 'Axeptiocookies',
                'fr' => 'Axeptiocookies',
            ],
            'class_name' => 'axeptiocookies',
            'parent_class_name' => 'CONFIGURE',
            'visible' => false,
        ],
        [
            'name' => [
                'en' => 'Axeptiocookies',
                'fr' => 'Axeptiocookies',
            ],
            'class_name' => 'AdminAxeptiocookiesParent',
            'parent_class_name' => 'axeptiocookies',
            'visible' => false,
        ],
        [
            'name' => [
                'en' => 'Configuration',
                'fr' => 'Configuration',
            ],
            'class_name' => 'AdminAxeptiocookiesConfiguration',
            'parent_class_name' => 'AdminAxeptiocookiesParent',
            'visible' => true,
        ],
        [
            'name' => [
                'en' => 'Configuration Ajax',
                'fr' => 'Configuration Ajax',
            ],
            'class_name' => 'AdminAxeptiocookiesConfigurationAjax',
            'parent_class_name' => 'axeptiocookies',
            'visible' => false,
        ],
    ];

    public function __construct()
    {
        $this->name = 'axeptiocookies';
        $this->version = '@version@';
        $this->author = '202 ecommerce';
        $this->tab = 'front_office_features';
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_,
        ];
        $this->need_instance = 0;
        $this->module_key = '699938714719e6f3e6e697c82c6ccff7';

        $this->__mConstruct();

        $this->secure_key = Tools::encrypt($this->name);
        $this->confirmUninstall = $this->l('This will delete the Axeptio cookies module, are you sure ?');
        $this->displayName = $this->l('Axeptio - Cookies and personal data management');
        $this->description = $this->l('Axeptio - Cookies and personal data management');
        $this->hookDispatcher = new HookDispatcher($this);
        $this->hooks = array_merge($this->hooks, $this->hookDispatcher->getAvailableHooks());
    }

    public function getContent()
    {
        Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminAxeptiocookiesConfiguration'));
    }

    public function isUsingNewTranslationSystem()
    {
        return false;
    }

    public function install()
    {
        $result = $this->mInstall();

        return $result;
    }

    public function uninstall()
    {
        return Module::uninstall();
    }

    /**
     * Handle Hooks loaded on extension
     *
     * @param string $name Hook name
     * @param array $arguments Hook arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if ($result = $this->handleExtensionsHook($name,
            !empty($arguments[0]) ? $arguments[0] : [])
        ) {
            if (!is_null($result)) {
                return $result;
            }
        }
    }
}
