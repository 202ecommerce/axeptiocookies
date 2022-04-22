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

namespace AxeptiocookiesAddon\Model\Integration;

class VendorModel
{
    protected $name;

    protected $title;

    protected $description;

    protected $type;

    protected $policyUrl;

    protected $domain;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return VendorModel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return VendorModel
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     *
     * @return VendorModel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     *
     * @return VendorModel
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPolicyUrl()
    {
        return $this->policyUrl;
    }

    /**
     * @param mixed $policyUrl
     *
     * @return VendorModel
     */
    public function setPolicyUrl($policyUrl)
    {
        $this->policyUrl = $policyUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param mixed $domain
     *
     * @return VendorModel
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public static function __set_state($array)
    {
        $obj = new VendorModel();
        $obj->setType($array['type']);
        $obj->setTitle($array['title']);
        $obj->setName($array['name']);
        $obj->setDescription($array['description']);
        $obj->setPolicyUrl($array['policyUrl']);
        $obj->setDomain($array['domain']);

        return $obj;
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'title' => $this->getTitle(),
            'longDescription' => $this->getDescription(),
            'shortDescription' => $this->getDescription(),
            'type' => $this->getType(),
            'policyUrl' => $this->getPolicyUrl(),
            'domain' => $this->getDomain(),
        ];
    }
}
