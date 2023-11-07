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

namespace AxeptiocookiesAddon\Utils;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Symfony\Component\Filesystem\Filesystem;

class GetViteVariablesUtils
{
    public function getViteVariables($entryPoint = null)
    {
        $js = [];
        $css = [];
        $jsEntry = '';
        $filesystem = new Filesystem();
        $path = '/modules/axeptiocookies/views/';
        $buildDir = _PS_ROOT_DIR_ . $path;
        $shop = \Context::getContext()->shop;
        $buildDirHttps = \Tools::getShopDomainSsl(true) . $shop->physical_uri . ltrim($path, '/');
        if ($filesystem->exists($buildDir)) {
            $manifest = $buildDir . 'manifest.json';
            if (!$filesystem->exists($manifest)) {
                throw new \Exception('manifest.json not exist');
            }
            $json = \Tools::file_get_contents($manifest);
            $json = json_decode($json, true);

            if (is_null($entryPoint)) {
                foreach ($json as $file) {
                    if (isset($file['file'])) {
                        if (isset($file['isEntry']) && $file['isEntry']) {
                            $jsEntry = $buildDirHttps . $file['file'];
                        } else {
                            $js[] = $buildDirHttps . $file['file'];
                        }
                    }
                    if (isset($file['css'])) {
                        foreach ($file['css'] as $entry) {
                            $css[] = $buildDirHttps . $entry;
                        }
                    }
                }
            } else {
                $manifestProcessor = new Manifest($manifest, $buildDirHttps);
                $jsEntry = $manifestProcessor->getEntrypoint($entryPoint)['url'];
                $js = array_map(function ($data) {
                    return $data['url'];
                }, $manifestProcessor->getImports($entryPoint));
                $css = array_map(function ($data) {
                    return $data['url'];
                }, $manifestProcessor->getStyles($entryPoint));
            }
        }

        return [
            'cssBuild' => $css,
            'jsBuild' => $js,
            'jsEntry' => $jsEntry,
        ];
    }
}
