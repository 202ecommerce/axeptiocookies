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
if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesAddon\Service\ConfigurationService;
use AxeptiocookiesAddon\Service\ModuleService;
use AxeptiocookiesAddon\Utils\GetViteVariablesUtils;
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
        $tpl->assign((new GetViteVariablesUtils())->getViteVariables('src/admin/js/main.ts'));

        return $tpl->fetch();
    }

    protected function getJsVariables()
    {
        return [
            'translations' => [
                'create' => [
                    'title' => $this->module->l('Creating a widget for your website', $this->controller_name),
                    'subtitle' => $this->module->l('To create a new widget, open your Axeptio interface to
                            retrieve the information', $this->controller_name),
                    'info_axeptio' => $this->module->l('Info Axeptio', $this->controller_name),
                    'info_ps' => $this->module->l('Info Prestashop', $this->controller_name),
                    'project_title' => $this->module->l('What is your Axeptio\'s project
                            ID', $this->controller_name),
                    'project_invalid' => $this->module->l('The project ID is not valid, remember that it is
                            necessary to publish the project in your Axeptio dashboard', $this->controller_name),
                    'configuration_title' => $this->module->l('What is your
                            configuration?', $this->controller_name),
                    'shop_title' => $this->module->l('To what shop this configuration should be linked
                            to?', $this->controller_name),
                    'language_title' => $this->module->l('To what language this configuration should be linked
                            to?', $this->controller_name),
                    'back' => $this->module->l('To the list', $this->controller_name),
                    'step_message' => $this->module->l('Message', $this->controller_name),
                    'step_title' => $this->module->l('Title', $this->controller_name),
                    'step_subtitle' => $this->module->l('Subtitle', $this->controller_name),
                ],
                'edit' => [
                    'title' => $this->module->l('Edit your widget', $this->controller_name),
                    'subtitle' => $this->module->l('Manage the appearance and modules you want to offer
                    for user consent', $this->controller_name),
                    'tabs' => [
                        'general' => $this->module->l('General', $this->controller_name),
                        'modules' => $this->module->l('Modules', $this->controller_name),
                        'consentv2' => $this->module->l('Consent Mode V2', $this->controller_name),
                    ],
                    'illustration' => $this->module->l('Illustration', $this->controller_name),
                    'illustration_choose' => $this->module->l('Choose illustration...', $this->controller_name),
                    'illustration_custom' => $this->module->l('I would like a
                        personalised illustration', $this->controller_name),
                    'no_illustration' => $this->module->l('I don\'t want an
                        illustration', $this->controller_name),
                    'paint' => $this->module->l('Activate the paint task', $this->controller_name),
                    'project_title' => $this->module->l('Project ID', $this->controller_name),
                    'configuration_title' => $this->module->l('Configuration', $this->controller_name),
                    'shop_title' => $this->module->l('Shops', $this->controller_name),
                    'language_title' => $this->module->l('Languages', $this->controller_name),
                    'back' => $this->module->l('To the list', $this->controller_name),
                    'step_message' => $this->module->l('Message', $this->controller_name),
                    'step_title' => $this->module->l('Title', $this->controller_name),
                    'step_subtitle' => $this->module->l('Subtitle', $this->controller_name),
                    'recommended' => [
                        'description' => $this->module->l('Collection of personal data', $this->controller_name),
                        'reset' => $this->module->l('Check the modules for which consent is recommended
                            by Axeptio', $this->controller_name),
                    ],
                    'consent' => [
                        'enable' => $this->module->l('Enable Google Consent Mode V2?', $this->controller_name),
                        'default' => $this->module->l('Default setting for Consent Mode', $this->controller_name),
                        'description' => $this->module->l('These consent signals will be sent on page load
                            to indicate to Google services how they should process the data before consent is given
                            by the user.', $this->controller_name),
                        'analytics_storage' => $this->module->l('Analytics storage', $this->controller_name),
                        'analytics_storage_desc' => $this->module->l('Allow Google Analytics to measure how
                            visitors use the site to improve functionality and service.', $this->controller_name),
                        'ad_storage' => $this->module->l('Ad Storage', $this->controller_name),
                        'ad_storage_desc' => $this->module->l('Allow Google to save advertising information on
                            visitors devices for better ad relevance.', $this->controller_name),
                        'ad_user_data' => $this->module->l('Ad User Data', $this->controller_name),
                        'ad_user_data_desc' => $this->module->l('Share visitor activity data with Google for
                            targeted advertising.', $this->controller_name),
                        'ad_personalization' => $this->module->l('Ad Personalization', $this->controller_name),
                        'ad_personalization_desc' => $this->module->l('Personalize the advertising experience
                            by allowing Google to personalize the ads visitors see.', $this->controller_name),
                    ],
                ],
                'example' => [
                    'accept' => $this->module->l('Accept all', $this->controller_name),
                    'next' => $this->module->l('Next', $this->controller_name),
                    'title' => $this->module->l('Title module', $this->controller_name),
                    'description' => $this->module->l('Description module', $this->controller_name),
                    'certified' => $this->module->l('Consents certified by', $this->controller_name),
                    'toggle_all' => $this->module->l('Toggle all', $this->controller_name),
                ],
                'common' => [
                    'save' => $this->trans('Save', [], 'Admin.Actions'),
                    'clear_cache' => $this->module->l('Clear cache', $this->controller_name),
                    'cache_title' => $this->module->l('Cache management', $this->controller_name),
                    'cache_description' => $this->module->l('Cache is purged automatically when it needed,
                                if you have some problems with displaying of Axeptio widget, try to use
                                this button', $this->controller_name),
                    'description' => [
                        'title' => $this->module->l('Important', $this->controller_name),
                        'desc1' => $this->module->l('The Axeptio widget allows you to be GDPR compliant and
                                let your users choose the consent and cookies they want to
                                activate.', $this->controller_name),
                        'desc2' => $this->module->l('To work, your account must be created and you already have a
                                project already created.', $this->controller_name),
                        'desc3' => sprintf(
                            $this->module->l('If this is not the case %sclick here to create your Axeptio account
                                and create your project%s', $this->controller_name),
                            '<a target="_blank" href="https://admin.axeptio.eu">', '</a>'),
                    ],
                    'error_occurred' => $this->module->l('Error occurred, try to reload
                            this page', $this->controller_name),
                ],
                'list' => [
                    'delete' => $this->module->l('Delete', $this->controller_name),
                    'delete_no' => $this->trans('No', [], 'Admin.Global'),
                    'delete_yes' => $this->trans('Yes', [], 'Admin.Global'),
                    'delete_confirmation' => $this->module->l('Are you sure you want delete this
                            widget?', $this->controller_name),
                    'new' => $this->module->l('Create an Axeptio widget', $this->controller_name),
                    'edit' => $this->module->l('Edit', $this->controller_name),
                    'configuration_unavailable' => $this->module->l('Axeptio widget is unavailable, it is
                            recommended to modify this widget', $this->controller_name),
                    'project_id' => $this->module->l('Project ID', $this->controller_name),
                    'shop' => $this->trans('Shop', [], 'Admin.Global'),
                    'language' => $this->trans('Language', [], 'Admin.Global'),
                    'table' => [
                        'widget' => $this->module->l('Widget', $this->controller_name),
                        'modification' => $this->module->l('Modification', $this->controller_name),
                        'deletion' => $this->module->l('Deletion', $this->controller_name),
                        'summary' => $this->module->l('Summary', $this->controller_name),
                    ],
                ],
            ],
            'links' => [
                'configuration' => '/' . str_replace(
                    Context::getContext()->link->getBaseLink(),
                    '',
                    Context::getContext()->link->getAdminLink($this->controller_name)
                ),
                'ajax' => '/' . str_replace(
                    Context::getContext()->link->getBaseLink(),
                    '',
                    Context::getContext()->link->getAdminLink('AdminAxeptiocookiesConfigurationAjax')
                ),
                'logo' => $this->moduleService->getModuleImageLink($this->module->name),
            ],
            'data' => [
                'shops' => Shop::getShops(false),
                'languages' => Language::getLanguages(false),
                'configurations' => $this->configurationService->getAll(),
            ],
            'images' => [
                'create' => '/modules/' . $this->module->name . '/views/img/create.png',
                'list' => '/modules/' . $this->module->name . '/views/img/list.png',
                'people' => '/modules/' . $this->module->name . '/views/img/people.png',
                'sky' => '/modules/' . $this->module->name . '/views/img/sky.png',
                'recommended' => '/modules/' . $this->module->name . '/views/img/recommended.svg',
            ],
        ];
    }
}
