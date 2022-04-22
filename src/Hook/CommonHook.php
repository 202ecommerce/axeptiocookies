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

class CommonHook extends AbstractHook
{
    const AVAILABLE_HOOKS = [
        'displayFooter',
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
}
