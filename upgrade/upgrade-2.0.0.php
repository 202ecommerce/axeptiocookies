<?php
/**
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

/**
 * @param Axeptiocookies $module
 * @return bool
 * @throws PrestaShopDatabaseException
 * @throws PrestaShopException
 */
function upgrade_module_2_0_0($module)
{
    $moduleInstaller = new \AxeptiocookiesClasslib\Install\ModuleInstaller($module);
    $moduleInstaller->install();

    /** @var \AxeptiocookiesAddon\Update\UpdateHandler $updateHandler */
    $updateHandler = \AxeptiocookiesAddon\Utils\ServiceContainer::getInstance()->get(
        \AxeptiocookiesAddon\Update\UpdateHandler::class
    );

    $idShops = Shop::getShops(true, null, true);

    foreach ($idShops as $idShop) {
        $idLanguages = Language::getLanguages(true, $idShop, true);
        foreach ($idLanguages as $idLang) {
            try {
                $key = Configuration::get(
                    'AXEPTIO_COOKIES_ID_KEY',
                    $idLang,
                    null,
                    $idShop
                );
                $version = Configuration::get(
                    'AXEPTIO_COOKIES_VERSION',
                    $idLang,
                    null,
                    $idShop
                );
                $updateHandler->createLangShopConfigurationFromParams(
                    $key,
                    $version,
                    $idShop,
                    $idLang
                );
            } catch (Exception $e) {
                PrestaShopLogger::addLog(
                    $e->getMessage(),
                    2,
                    null,
                    'axeptiocookies'
                );
            }
        }
    }

    return true;
}
