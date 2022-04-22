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

namespace AxeptiocookiesAddon\Entity;

use ObjectModel;
use Shop;

class AxeptioConfiguration extends ObjectModel
{
    /**
     * @var int
     */
    public $id_axeptiocookies_configuration;

    /**
     * @var string
     */
    public $id_configuration;

    /**
     * @var string
     */
    public $id_project;

    /**
     * @var int
     */
    public $id_lang;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $subtitle;

    public function __construct($id = null, $id_lang = null, $id_shop = null, $translator = null)
    {
        parent::__construct($id, $id_lang, $id_shop, $translator);
        Shop::addTableAssociation(self::$definition['table'], ['type' => 'shop']);
    }

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'axeptiocookies_configuration',
        'multishop' => true,
        'primary' => 'id_axeptiocookies_configuration',
        'fields' => [
            'id_configuration' => [
                'type' => self::TYPE_STRING,
                'required' => true,
            ],
            'id_project' => [
                'type' => self::TYPE_STRING,
                'required' => true,
            ],
            'id_lang' => [
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
                'required' => true,
            ],
            'message' => [
                'type' => self::TYPE_STRING,
                'required' => false,
                'size' => 512,
            ],
            'title' => [
                'type' => self::TYPE_STRING,
                'required' => false,
                'size' => 255,
            ],
            'subtitle' => [
                'type' => self::TYPE_STRING,
                'required' => false,
                'size' => 255,
            ],
        ],
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'id_configuration' => $this->id_configuration,
            'id_project' => $this->id_project,
            'id_lang' => $this->id_lang,
            'message' => $this->message,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'shops' => $this->getAssociatedShops(),
        ];
    }
}
