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

namespace AxeptiocookiesAddon\Entity;

class AxeptioConfiguration extends \ObjectModel
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
        \Shop::addTableAssociation(self::$definition['table'], ['type' => 'shop']);
    }

    /**
     * @var array
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
