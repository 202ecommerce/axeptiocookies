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

namespace AxeptiocookiesAddon\Model\Integration;

if (!defined('_PS_VERSION_')) {
    exit;
}

class VendorModel
{
    protected $name;

    protected $title;

    protected $description;

    protected $type;

    protected $policyUrl;

    protected $domain;

    protected $image;

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

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return VendorModel
     */
    public function setImage($image)
    {
        $this->image = $image;

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
        $obj->setImage($array['image']);

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
            'image' => $this->getImage(),
        ];
    }
}
