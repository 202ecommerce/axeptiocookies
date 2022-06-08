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

    /**
     * @var bool
     */
    public $bootstrap = false;

    /**
     * @var int
     */
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

        $this->addJS(_PS_MODULE_DIR_ . 'axeptiocookies/views/js/admin.' . $this->module->version . '.js');
        $this->addCSS(_PS_MODULE_DIR_ . 'axeptiocookies/views/css/admin.' . $this->module->version . '.css');
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
                    'title' => $this->l('Creating a widget for your website'),
                    'subtitle' => $this->l('To create a new widget, open your Axeptio interface to retrieve the information'),
                    'info_axeptio' => $this->l('Info Axeptio'),
                    'info_ps' => $this->l('Info Prestashop'),
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
                    'title' => $this->l('Edit your widget'),
                    'subtitle' => $this->l('Manage the appearance and modules you want to offer for user consent'),
                    'tabs' => [
                        'general' => $this->l('General'),
                        'modules' => $this->l('Modules'),
                    ],
                    'project_title' => $this->l('Project ID'),
                    'configuration_title' => $this->l('Configuration'),
                    'shop_title' => $this->l('Shops'),
                    'language_title' => $this->l('Languages'),
                    'back' => $this->l('To the list'),
                    'step_message' => $this->l('Message'),
                    'step_title' => $this->l('Title'),
                    'step_subtitle' => $this->l('Subtitle'),
                ],
                'example' => [
                    'accept' => $this->l('Accept all'),
                    'next' => $this->l('Next'),
                    'title' => $this->l('Title module'),
                    'description' => $this->l('Description module'),
                    'certified' => $this->l('Consents certified by'),
                    'toggle_all' => $this->l('Toggle all'),
                ],
                'common' => [
                    'save' => $this->trans('Save', [], 'Admin.Actions'),
                    'clear_cache' => $this->l('Clear cache'),
                    'cache_title' => $this->l('Cache management'),
                    'cache_description' => $this->l('Cache is purged automatically when it needed,
                                if you have some problems with displaying of Axeptio widget, try to use this button'),
                    'description' => [
                        'title' => $this->l('Important'),
                        'desc1' => $this->l('The Axeptio widget allows you to be GDPR compliant and let your 
                                users choose the consent and cookies they want to activate.'),
                        'desc2' => $this->l('To work, your account must be created and you already have a 
                                project already created.'),
                        'desc3' => sprintf(
                            $this->l('If this is not the case %sclick here to create your Axeptio account and create your project%s'),
                            '<a target="_blank" href="https://admin.axeptio.eu">', '</a>'),
                    ],
                    'error_occurred' => $this->l('Error occurred, try to reload this page'),
                ],
                'list' => [
                    'delete' => $this->l('Delete'),
                    'delete_no' => $this->trans('No', [], 'Admin.Global'),
                    'delete_yes' => $this->trans('Yes', [], 'Admin.Global'),
                    'delete_confirmation' => $this->l('Are you sure you want delete this widget?'),
                    'new' => $this->l('Create an Axeptio widget'),
                    'edit' => $this->l('Edit'),
                    'configuration_unavailable' => $this->l('Axeptio widget is unavailable, it is recommended to modify this widget'),
                    'project_id' => $this->l('Project ID'),
                    'shop' => $this->trans('Shop', [], 'Admin.Global'),
                    'language' => $this->trans('Language', [], 'Admin.Global'),
                    'table' => [
                        'widget' => $this->l('Widget'),
                        'modification' => $this->l('Modification'),
                        'deletion' => $this->l('Deletion'),
                        'summary' => $this->l('Summary'),
                    ]
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
                'people' => '/modules/' . $this->module->name . '/views/img/people.avif',
                'sky' => '/modules/' . $this->module->name . '/views/img/sky.png',
            ],
        ];
    }
}
