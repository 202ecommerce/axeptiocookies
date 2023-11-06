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

use AxeptiocookiesAddon\Service\HookService;
use AxeptiocookiesAddon\Smarty\CookiesCompletePrefilter;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use AxeptiocookiesClasslib\Hook\AbstractHook;

class CommonHook extends AbstractHook
{
    const AVAILABLE_HOOKS = [
        'displayFooter',
        'actionDispatcherBefore',
        'actionDispatcher',
    ];

    public function displayFooter($params)
    {
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
        }

        if ($params['controller_type'] != \Dispatcher::FC_FRONT) {
            return;
        }

        if (empty($_COOKIE[HookService::DEFAULT_COOKIE_NAME])) {
            return;
        }

        $idShop = \Context::getContext()->shop->id;
        $languages = \Language::getLanguages(true, $idShop);

        foreach ($languages as $language) {
            if (isset($_COOKIE[HookService::DEFAULT_COOKIE_NAME])) {
                setcookie(
                    HookService::DEFAULT_COOKIE_NAME . '_' . $language['iso_code'],
                    $_COOKIE[HookService::DEFAULT_COOKIE_NAME],
                    strtotime('+1 year'),
                    '/',
                    '',
                    true
                );
            }
            if (isset($_COOKIE[HookService::DEFAULT_COOKIE_AUTHORIZED_VENDORS])) {
                setcookie(
                    HookService::DEFAULT_COOKIE_AUTHORIZED_VENDORS . '_' . $language['iso_code'],
                    $_COOKIE[HookService::DEFAULT_COOKIE_AUTHORIZED_VENDORS],
                    strtotime('+1 year'),
                    '/',
                    '',
                    true
                );
            }
            if (isset($_COOKIE[HookService::DEFAULT_COOKIE_ALL_VENDORS])) {
                setcookie(
                    HookService::DEFAULT_COOKIE_ALL_VENDORS . '_' . $language['iso_code'],
                    $_COOKIE[HookService::DEFAULT_COOKIE_ALL_VENDORS],
                    strtotime('+1 year'),
                    '/',
                    '',
                    true
                );
            }
        }

        unset($_COOKIE[HookService::DEFAULT_COOKIE_NAME]);
        setcookie(HookService::DEFAULT_COOKIE_NAME, '', time() - 3600, '/', '', true);

        unset($_COOKIE[HookService::DEFAULT_COOKIE_AUTHORIZED_VENDORS]);
        setcookie(HookService::DEFAULT_COOKIE_AUTHORIZED_VENDORS, '', time() - 3600, '/', '', true);

        unset($_COOKIE[HookService::DEFAULT_COOKIE_ALL_VENDORS]);
        setcookie(HookService::DEFAULT_COOKIE_ALL_VENDORS, '', time() - 3600, '/', '', true);
    }
}
