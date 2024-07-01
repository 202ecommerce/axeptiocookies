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

namespace AxeptiocookiesAddon\Service;

if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesAddon\Entity\AxeptioConfiguration;

class ImageService
{
    const IMG_DIR = _PS_IMG_DIR_ . 'module/axeptiocookies/';

    public function getIllustration(AxeptioConfiguration $configuration)
    {
        if (empty($configuration->has_illustration) || empty($configuration->illustration) || !file_exists(self::IMG_DIR . $configuration->illustration)) {
            return null;
        }
        $imgData = base64_encode(\Tools::file_get_contents(self::IMG_DIR . $configuration->illustration));

        return 'data: ' . mime_content_type(self::IMG_DIR . $configuration->illustration) . ';base64,' . $imgData;
    }

    public function saveImage($image)
    {
        if (empty($image)) {
            return null;
        }
        $this->createImgDirIfNotExists();
        $fileName = md5($image) . '_' . uniqid();
        $splited = explode(',', substr($image, 5), 2);
        $mime = $splited[0];
        $data = $splited[1];

        $mimeSplitWithoutBase64 = explode(';', $mime, 2);
        $mimeSplit = explode('/', $mimeSplitWithoutBase64[0], 2);
        if (count($mimeSplit) == 2) {
            $extension = $mimeSplit[1];
            if ($extension == 'jpeg') {
                $extension = 'jpg';
            }
            if ($extension == 'svg+xml') {
                $extension = 'svg';
            }
            $fileName = $fileName . '.' . $extension;
        }
        file_put_contents(self::IMG_DIR . $fileName, base64_decode($data));

        return $fileName;
    }

    public function deleteImage($fileName)
    {
        if (file_exists(self::IMG_DIR . $fileName)) {
            unlink(self::IMG_DIR . $fileName);
        }
    }

    public function getImageUrl($illustration, $idShop)
    {
        if (empty($illustration) || !file_exists(self::IMG_DIR . $illustration)) {
            return null;
        }

        if (empty($idShop)) {
            $idShop = \Context::getContext()->shop->id;
        }

        $uriPath = (new \Shop($idShop))->getBaseURI() . 'img/module/axeptiocookies/' . $illustration;

        return \Context::getContext()->link->protocol_content . \Tools::getMediaServer($uriPath) . $uriPath;
    }

    protected function createImgDirIfNotExists()
    {
        if (!@is_dir(self::IMG_DIR)) {
            @mkdir(self::IMG_DIR, 0755, true);
        } else {
            @chmod(self::IMG_DIR, 0755);
        }
    }
}
