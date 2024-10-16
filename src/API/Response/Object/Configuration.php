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

namespace AxeptiocookiesAddon\API\Response\Object;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Configuration extends AbstractObject
{
    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $language;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    public function build($json)
    {
        if (empty($json)
            || !array_key_exists('identifier', $json)
            || !array_key_exists('language', $json)
            || empty($json['name'])
            || empty($json['title'])) {
            return null;
        }

        $this->id = $json['identifier'];
        $this->language = $json['language'];
        $this->name = $json['name'];
        $this->title = $json['title'];

        return $this;
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
