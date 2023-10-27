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

class AxeptioModuleConfiguration extends \ObjectModel
{
    /**
     * @var int
     */
    public $id_axeptiocookies_module_configuration;

    /**
     * @var int
     */
    public $id_axeptiocookies_configuration;

    /**
     * @var string
     */
    public $module_name;

    /**
     * @var array
     */
    public static $definition = [
        'table' => 'axeptiocookies_module_configuration',
        'primary' => 'id_axeptiocookies_module_configuration',
        'fields' => [
            'id_axeptiocookies_configuration' => [
                'type' => self::TYPE_INT,
                'validation' => 'isUnsignedInt',
                'required' => true,
            ],
            'module_name' => [
                'type' => self::TYPE_STRING,
                'required' => false,
            ],
        ],
    ];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'id_axeptiocookies_configuration' => $this->id_axeptiocookies_configuration,
            'module_name' => $this->module_name,
        ];
    }
}
