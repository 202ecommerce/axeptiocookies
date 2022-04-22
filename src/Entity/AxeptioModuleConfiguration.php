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

class AxeptioModuleConfiguration extends ObjectModel
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
     * @see ObjectModel::$definition
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
