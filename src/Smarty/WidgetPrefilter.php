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

namespace AxeptiocookiesAddon\Smarty;

if (!defined('_PS_VERSION_')) {
    exit;
}

class WidgetPrefilter
{
    public static function addAxeptioWidget($source)
    {
        $stringToSearch = '/<\/body>/ims';
        preg_match($stringToSearch, $source, $matches, PREG_OFFSET_CAPTURE, 0);
        if (empty($matches)) {
            return $source;
        }

        $replace = "{hook h='displayAxeptioWidget'}\r" . '</body>';

        return preg_replace($stringToSearch, $replace, $source);
    }
}
