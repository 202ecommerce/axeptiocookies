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

class StepModel implements \JsonSerializable
{
    /**
     * @var bool
     */
    protected $hasVendors = true;

    /**
     * @var string
     */
    protected $image = 'cookie-bienvenue';

    /**
     * @var string
     */
    protected $layout = 'category';

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $name = 'ps-modules';

    /**
     * @var bool
     */
    protected $onlyOnce = true;

    protected $showToggleAllSwitch = true;

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $subTitle = '';

    /**
     * @var bool
     */
    protected $disablePaint = false;

    /**
     * @var array<VendorModel>
     */
    protected $vendors = [];

    /**
     * @return bool
     */
    public function isHasVendors()
    {
        return $this->hasVendors;
    }

    /**
     * @param bool $hasVendors
     *
     * @return StepModel
     */
    public function setHasVendors($hasVendors)
    {
        $this->hasVendors = $hasVendors;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return StepModel
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     *
     * @return StepModel
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return StepModel
     */
    public function setMessage($message)
    {
        $this->message = $message;

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
     * @return StepModel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOnlyOnce()
    {
        return $this->onlyOnce;
    }

    /**
     * @param bool $onlyOnce
     *
     * @return StepModel
     */
    public function setOnlyOnce($onlyOnce)
    {
        $this->onlyOnce = $onlyOnce;

        return $this;
    }

    /**
     * @return bool
     */
    public function isShowToggleAllSwitch()
    {
        return $this->showToggleAllSwitch;
    }

    /**
     * @param bool $showToggleAllSwitch
     *
     * @return StepModel
     */
    public function setShowToggleAllSwitch($showToggleAllSwitch)
    {
        $this->showToggleAllSwitch = $showToggleAllSwitch;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return StepModel
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * @param string $subTitle
     *
     * @return StepModel
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * @return VendorModel[]
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * @param VendorModel[] $vendors
     *
     * @return StepModel
     */
    public function setVendors($vendors)
    {
        $this->vendors = $vendors;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDisablePaint()
    {
        return $this->disablePaint;
    }

    /**
     * @param bool $disablePaint
     *
     * @return StepModel
     */
    public function setDisablePaint($disablePaint)
    {
        $this->disablePaint = $disablePaint;

        return $this;
    }

    public static function __set_state($array)
    {
        $obj = new StepModel();
        $obj->setHasVendors((bool) $array['hasVendors']);
        $obj->setImage($array['image']);
        $obj->setLayout($array['layout']);
        $obj->setMessage($array['message']);
        $obj->setName($array['name']);
        $obj->setOnlyOnce((bool) $array['onlyOnce']);
        $obj->setShowToggleAllSwitch((bool) $array['showToggleAllSwitch']);
        $obj->setSubTitle($array['subTitle']);
        $obj->setTitle($array['title']);
        $obj->setVendors($array['vendors']);
        $obj->setDisablePaint(isset($array['disablePaint']) && (bool) $array['disablePaint']);

        return $obj;
    }

    public function toArray()
    {
        return [
            'hasVendors' => $this->isHasVendors(),
            'image' => $this->getImage(),
            'layout' => $this->getLayout(),
            'message' => $this->getMessage(),
            'name' => $this->getName(),
            'onlyOnce' => $this->isOnlyOnce(),
            'showToggleAllSwitch' => $this->isShowToggleAllSwitch(),
            'subTitle' => $this->getSubTitle(),
            'title' => $this->getTitle(),
            'disablePaint' => $this->getDisablePaint(),
            'vendors' => array_map(function (VendorModel $vendorModel) {
                return $vendorModel->toArray();
            }, $this->getVendors()),
        ];
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
