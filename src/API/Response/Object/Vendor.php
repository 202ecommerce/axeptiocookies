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

namespace AxeptiocookiesAddon\API\Response\Object;

use Context;

class Vendor extends AbstractObject
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var bool
     */
    protected $isRequired = false;

    public function build($json)
    {
        if (empty($json) || empty($json['id']) || empty($json['state']) || empty($json['data']['name'])) {
            return $this;
        }

        $this
            ->setId($json['id'])
            ->setState($json['state'])
            ->setName($json['data']['name']);

        if (empty($json['data'])) {
            return $this;
        }

        if (!empty($json['data']['hooks'][0]['consentRequirements'])) {
            $this->setIsRequired($json['data']['hooks'][0]['consentRequirements'] == 'required');
        }

        if (!empty($json['data']['url'])) {
            $this->setUrl($json['data']['url']);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Vendor
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Vendor
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Vendor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return Vendor
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->isRequired;
    }

    /**
     * @param bool $isRequired
     *
     * @return Vendor
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    public static function __set_state($data)
    {
        $obj = new self();
        if (!empty($data['id'])) {
            $obj->setId($data['id']);
        }
        if (!empty($data['state'])) {
            $obj->setState($data['state']);
        }
        if (!empty($data['name'])) {
            $obj->setName($data['name']);
        }
        if (!empty($data['url'])) {
            $obj->setUrl($data['url']);
        }
        if (!empty($data['isRequired'])) {
            $obj->setIsRequired($data['isRequired']);
        }

        return $obj;
    }
}
