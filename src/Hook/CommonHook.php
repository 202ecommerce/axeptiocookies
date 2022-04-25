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

namespace AxeptiocookiesAddon\Hook;

use AxeptiocookiesAddon\Service\HookService;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use AxeptiocookiesClasslib\Hook\AbstractHook;
use Context;
use Dispatcher;
use Language;

class CommonHook extends AbstractHook
{
    const AVAILABLE_HOOKS = [
        'displayFooter',
        'actionDispatcherBefore',
    ];

    public function displayFooter($params)
    {
        /** @var HookService $hookService */
        $hookService = ServiceContainer::getInstance()->get(HookService::class);

        $integrationModel = $hookService->getIntegrationModelFromContext();

        if (empty($integrationModel)) {
            return;
        }

        $tpl = Context::getContext()->smarty->createTemplate(
            'module:axeptiocookies/views/templates/front/hook/footer.tpl'
        );
        $tpl->assign([
            'integration' => $integrationModel->toArray(),
        ]);

        return $tpl->fetch();
    }

    public function actionDispatcherBefore($params)
    {
        if ($params['controller_type'] != Dispatcher::FC_FRONT) {
            return;
        }

        if (empty($_COOKIE[HookService::DEFAULT_COOKIE_NAME])) {
            return;
        }

        $idShop = Context::getContext()->shop->id;
        $languages = Language::getLanguages(true, $idShop);

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
