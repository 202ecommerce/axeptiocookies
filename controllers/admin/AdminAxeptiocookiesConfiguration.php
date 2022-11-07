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

    protected function getJsVariables()
    {
        return [
            'translations' => [
                'create' => [
                    'title' => $this->l('Creating a widget for your website', $this->controller_name),
                    'subtitle' => $this->l('To create a new widget, open your Axeptio interface to retrieve the information', $this->controller_name),
                    'info_axeptio' => $this->l('Info Axeptio', $this->controller_name),
                    'info_ps' => $this->l('Info Prestashop', $this->controller_name),
                    'project_title' => $this->l('What is your Axeptio\'s project ID', $this->controller_name),
                    'project_invalid' => $this->l('The project ID is not valid, remember that it is necessary to publish the project in your Axeptio dashboard', $this->controller_name),
                    'configuration_title' => $this->l('What is your configuration?', $this->controller_name),
                    'shop_title' => $this->l('To what shop this configuration should be linked to?', $this->controller_name),
                    'language_title' => $this->l('To what language this configuration should be linked to?', $this->controller_name),
                    'back' => $this->l('To the list', $this->controller_name),
                    'step_message' => $this->l('Message', $this->controller_name),
                    'step_title' => $this->l('Title', $this->controller_name),
                    'step_subtitle' => $this->l('Subtitle', $this->controller_name),
                ],
                'edit' => [
                    'title' => $this->l('Edit your widget', $this->controller_name),
                    'subtitle' => $this->l('Manage the appearance and modules you want to offer for user consent', $this->controller_name),
                    'tabs' => [
                        'general' => $this->l('General', $this->controller_name),
                        'modules' => $this->l('Modules', $this->controller_name),
                    ],
                    'project_title' => $this->l('Project ID', $this->controller_name),
                    'configuration_title' => $this->l('Configuration', $this->controller_name),
                    'shop_title' => $this->l('Shops', $this->controller_name),
                    'language_title' => $this->l('Languages', $this->controller_name),
                    'back' => $this->l('To the list', $this->controller_name),
                    'step_message' => $this->l('Message', $this->controller_name),
                    'step_title' => $this->l('Title', $this->controller_name),
                    'step_subtitle' => $this->l('Subtitle', $this->controller_name),
                ],
                'example' => [
                    'accept' => $this->l('Accept all', $this->controller_name),
                    'next' => $this->l('Next', $this->controller_name),
                    'title' => $this->l('Title module', $this->controller_name),
                    'description' => $this->l('Description module', $this->controller_name),
                    'certified' => $this->l('Consents certified by', $this->controller_name),
                    'toggle_all' => $this->l('Toggle all', $this->controller_name),
                ],
                'common' => [
                    'save' => $this->trans('Save', [], 'Admin.Actions'),
                    'clear_cache' => $this->l('Clear cache', $this->controller_name),
                    'cache_title' => $this->l('Cache management', $this->controller_name),
                    'cache_description' => $this->l('Cache is purged automatically when it needed,
                                if you have some problems with displaying of Axeptio widget, try to use this button', $this->controller_name),
                    'description' => [
                        'title' => $this->l('Important', $this->controller_name),
                        'desc1' => $this->l('The Axeptio widget allows you to be GDPR compliant and let your 
                                users choose the consent and cookies they want to activate.', $this->controller_name),
                        'desc2' => $this->l('To work, your account must be created and you already have a 
                                project already created.', $this->controller_name),
                        'desc3' => sprintf(
                            $this->l('If this is not the case %sclick here to create your Axeptio account and create your project%s', $this->controller_name),
                            '<a target="_blank" href="https://admin.axeptio.eu">', '</a>'),
                    ],
                    'error_occurred' => $this->l('Error occurred, try to reload this page', $this->controller_name),
                ],
                'list' => [
                    'delete' => $this->l('Delete', $this->controller_name),
                    'delete_no' => $this->trans('No', [], 'Admin.Global'),
                    'delete_yes' => $this->trans('Yes', [], 'Admin.Global'),
                    'delete_confirmation' => $this->l('Are you sure you want delete this widget?'),
                    'new' => $this->l('Create an Axeptio widget', $this->controller_name),
                    'edit' => $this->l('Edit', $this->controller_name),
                    'configuration_unavailable' => $this->l('Axeptio widget is unavailable, it is recommended to modify this widget', $this->controller_name),
                    'project_id' => $this->l('Project ID', $this->controller_name),
                    'shop' => $this->trans('Shop', [], 'Admin.Global'),
                    'language' => $this->trans('Language', [], 'Admin.Global'),
                    'table' => [
                        'widget' => $this->l('Widget', $this->controller_name),
                        'modification' => $this->l('Modification', $this->controller_name),
                        'deletion' => $this->l('Deletion', $this->controller_name),
                        'summary' => $this->l('Summary', $this->controller_name),
                    ],
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
