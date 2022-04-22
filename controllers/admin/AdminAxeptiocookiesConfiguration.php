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

use AxeptiocookiesAddon\Service\ConfigurationService;
use AxeptiocookiesAddon\Service\ModuleService;
use AxeptiocookiesAddon\Utils\ServiceContainer;

class AdminAxeptiocookiesConfigurationController extends ModuleAdminController
{
    /** @var \Module Instance of your module automatically set by ModuleAdminController */
    public $module;

    /** @var string Associated object class name */
    public $className = 'Configuration';

    /** @var string Associated table name */
    public $table = 'configuration';

    /** @var string Associated table name */
    public $bootstrap = false;

    public $multishop_context = 0;

    /**
     * @var ConfigurationService
     */
    protected $configurationService;

    /**
     * @var ModuleService
     */
    protected $moduleService;

    public function __construct()
    {
        parent::__construct();
        $this->configurationService = ServiceContainer::getInstance()->get(ConfigurationService::class);
        $this->moduleService = ServiceContainer::getInstance()->get(ModuleService::class);
    }

    /**
     * @see AdminController::initPageHeaderToolbar()
     */
    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();
        // Remove the help icon of the toolbar which no useful for us
        $this->context->smarty->clearAssign('help_link');
    }

    public function setMedia($isNewTheme = false)
    {
        parent::setMedia($isNewTheme);

        $this->addJS(_PS_MODULE_DIR_ . 'axeptiocookies/views/js/admin.js');
        $this->addCSS(_PS_MODULE_DIR_ . 'axeptiocookies/views/css/admin.css');
        Media::addJsDef([
            $this->module->name => $this->getJsVariables(),
        ]);
    }

    public function initContent()
    {
        $this->content .= $this->renderConfiguration();
        parent::initContent();
    }

    protected function renderConfiguration()
    {
        $tplFile = _PS_MODULE_DIR_ . 'axeptiocookies/views/templates/admin/configuration/layout.tpl';

        $tpl = Context::getContext()->smarty->createTemplate($tplFile);
        $tpl->assign([
        ]);

        return $tpl->fetch();
    }

    public function postProcess()
    {
        return parent::postProcess();
    }

    protected function getJsVariables()
    {
        return [
            'translations' => [
                'create' => [
                    'title' => $this->l('Create new association'),
                    'project_title' => $this->l('What is your Axeptio\'s project ID'),
                    'project_invalid' => $this->l('Project ID is invalid'),
                    'configuration_title' => $this->l('What is your configuration?'),
                    'shop_title' => $this->l('To what shop this configuration should be linked to?'),
                    'language_title' => $this->l('To what language this configuration should be linked to?'),
                    'back' => $this->l('To the list'),
                    'step_message' => $this->l('Message'),
                    'step_title' => $this->l('Title'),
                    'step_subtitle' => $this->l('Subtitle'),
                ],
                'edit' => [
                    'title' => $this->l('Edit association'),
                    'project_title' => $this->l('Project ID'),
                    'configuration_title' => $this->l('Configuration'),
                    'shop_title' => $this->l('Shops'),
                    'language_title' => $this->l('Languages'),
                    'modules_title' => $this->l('Modules'),
                    'back' => $this->l('To the list'),
                    'step_message' => $this->l('Message'),
                    'step_title' => $this->l('Title'),
                    'step_subtitle' => $this->l('Subtitle'),
                ],
                'common' => [
                    'save' => $this->trans('Save', [], 'Admin.Actions'),
                    'clear_cache' => $this->l('Clear cache'),
                    'cache_title' => $this->l('Cache management'),
                    'cache_description' => $this->l('Cache is purged automatically when it needed,
                                if you have some problems with displaying of Axeptio widget, try to use this button'),
                    'description' => [
                        'title' => $this->l('Axeptio - cookies and personal data management'),
                        'configure' => sprintf(
                            $this->l('The informations needed to configure this module are on your admin panel on %s'),
                            '<a target="_blank" href="https://admin.axeptio.eu">admin.axeptio.eu</a>'),
                        'documentation' => sprintf(
                            $this->l('Technical documentation : %s'),
                            '<a target="_blank"
                                          href="https://developers.axeptio.eu/integration/integration-cms/integration-prestashop">
                                          developers.axeptio.eu/integration/integration-cms/integration-prestashop
                                      </a>'
                        ),
                    ],
                    'error_occurred' => $this->l('Error occurred, try to reload this page'),
                ],
                'list' => [
                    'delete' => $this->l('Delete this association'),
                    'delete_no' => $this->trans('No', [], 'Admin.Global'),
                    'delete_yes' => $this->trans('Yes', [], 'Admin.Global'),
                    'delete_confirmation' => $this->l('Are you sure you want delete this association?'),
                    'new' => $this->l('Create new association'),
                    'new_description' => $this->l('Create new association between an Axeptio configuration and a shop/language in PrestaShop'),
                    'edit' => $this->l('Edit modules subject to consent'),
                    'configuration_unavailable' => $this->l('Axeptio configuration unavailable, it is recommended to modify this association'),
                    'project_id' => $this->l('Project ID'),
                    'shop' => $this->trans('Shop', [], 'Admin.Global'),
                    'language' => $this->trans('Language', [], 'Admin.Global'),
                ],
            ],
            'links' => [
                'configuration' => '/' . str_replace(
                        Context::getContext()->link->getBaseLink(),
                        '',
                        Context::getContext()->link->getAdminLink($this->controller_name)
                    ),
                'ajax' => Context::getContext()->link->getAdminLink('AdminAxeptiocookiesConfigurationAjax'),
                'logo' => $this->moduleService->getModuleImageLink($this->module->name),
            ],
            'data' => [
                'shops' => Shop::getShops(false),
                'languages' => Language::getLanguages(false),
                'configurations' => $this->configurationService->getAll(),
            ],
            'images' => [
                'create' => '/modules/' . $this->module->name . '/views/img/create.avif',
                'list' => '/modules/' . $this->module->name . '/views/img/list.avif',
            ],
        ];
    }
}
