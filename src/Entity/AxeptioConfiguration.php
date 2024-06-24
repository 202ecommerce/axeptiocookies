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

if (!defined('_PS_VERSION_')) {
    exit;
}

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

    /**
     * @var bool
     */
    public $is_consent_v2 = false;

    /**
     * @var bool
     */
    public $analytics_storage = false;

    /**
     * @var bool
     */
    public $ad_storage = false;

    /**
     * @var bool
     */
    public $ad_user_data = false;

    /**
     * @var bool
     */
    public $ad_personalization = false;

    /**
     * @var bool
     */
    public $paint = true;

    /**
     * @var bool
     */
    public $has_illustration = false;

    /**
     * @var string|null
     */
    public $illustration;

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
            'is_consent_v2' => [
                'type' => self::TYPE_BOOL,
                'required' => false,
                'validate' => 'isBool',
            ],
            'analytics_storage' => [
                'type' => self::TYPE_BOOL,
                'required' => false,
                'validate' => 'isBool',
            ],
            'ad_storage' => [
                'type' => self::TYPE_BOOL,
                'required' => false,
                'validate' => 'isBool',
            ],
            'ad_user_data' => [
                'type' => self::TYPE_BOOL,
                'required' => false,
                'validate' => 'isBool',
            ],
            'ad_personalization' => [
                'type' => self::TYPE_BOOL,
                'required' => false,
                'validate' => 'isBool',
            ],
            'paint' => [
                'type' => self::TYPE_BOOL,
                'required' => false,
                'validate' => 'isBool',
            ],
            'has_illustration' => [
                'type' => self::TYPE_BOOL,
                'required' => false,
                'validate' => 'isBool',
            ],
            'illustration' => [
                'type' => self::TYPE_STRING,
                'required' => false,
                'size' => 255,
                'validate' => 'isCleanHtml',
                'allow_null' => true,
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
            'is_consent_v2' => $this->is_consent_v2,
            'analytics_storage' => $this->analytics_storage,
            'ad_storage' => $this->ad_storage,
            'ad_user_data' => $this->ad_user_data,
            'ad_personalization' => $this->ad_personalization,
            'paint' => $this->paint,
            'illustration' => $this->illustration,
            'has_illustration' => $this->has_illustration,
        ];
    }
}
