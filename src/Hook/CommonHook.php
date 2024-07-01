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

namespace AxeptiocookiesAddon\Hook;

if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesAddon\Service\HookService;
use AxeptiocookiesAddon\Smarty\CookiesCompletePrefilter;
use AxeptiocookiesAddon\Smarty\WidgetPrefilter;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use AxeptiocookiesClasslib\Hook\AbstractHook;

class CommonHook extends AbstractHook
{
    const AVAILABLE_HOOKS = [
        'actionDispatcherBefore',
        'displayAxeptioWidget',
    ];

    public function displayAxeptioWidget($params)
    {
        if (\Tools::getValue('ajax') !== false) {
            return;
        }

        /** @var HookService $hookService */
        $hookService = ServiceContainer::getInstance()->get(HookService::class);

        $integrationModel = $hookService->getIntegrationModelFromContext();

        if (empty($integrationModel)) {
            return;
        }

        $tpl = \Context::getContext()->smarty->createTemplate(
            'module:axeptiocookies/views/templates/front/hook/footer.tpl'
        );
        $tpl->assign([
            'integration' => $integrationModel->toArray(),
        ]);

        return $tpl->fetch();
    }

    public function actionDispatcherBefore($params)
    {
        if ($params['controller_type'] != \Dispatcher::FC_ADMIN) {
            \Context::getContext()->smarty->registerFilter(
                'output',
                [
                    CookiesCompletePrefilter::class,
                    'handleCookiesComplete',
                ],
                'handleCookiesComplete'
            );
            \Context::getContext()->smarty->registerFilter(
                'pre',
                [
                    WidgetPrefilter::class,
                    'addAxeptioWidget',
                ],
                'addAxeptioWidget'
            );
        }

        if ($params['controller_type'] != \Dispatcher::FC_FRONT) {
            return;
        }

        /** @var \AxeptiocookiesAddon\Update\UpdateHandler $updateHandler */
        $updateHandler = \AxeptiocookiesAddon\Utils\ServiceContainer::getInstance()->get(
            \AxeptiocookiesAddon\Update\UpdateHandler::class
        );
        $updateHandler->setDefaultCookieFromLangCookies();
    }
}
