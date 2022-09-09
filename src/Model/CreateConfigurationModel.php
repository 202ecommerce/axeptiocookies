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

namespace AxeptiocookiesAddon\Model;

class CreateConfigurationModel
{
    /**
     * @var string
     */
    protected $idProject;

    /**
     * @var string
     */
    protected $idConfiguration;

    /**
     * @var array
     */
    protected $idShops;

    /**
     * @var int
     */
    protected $idLanguage;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $subtitle;

    /**
     * @return string
     */
    public function getIdProject()
    {
        return $this->idProject;
    }

    /**
     * @param string $idProject
     *
     * @return CreateConfigurationModel
     */
    public function setIdProject($idProject)
    {
        $this->idProject = $idProject;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdConfiguration()
    {
        return $this->idConfiguration;
    }

    /**
     * @param string $idConfiguration
     *
     * @return CreateConfigurationModel
     */
    public function setIdConfiguration($idConfiguration)
    {
        $this->idConfiguration = $idConfiguration;

        return $this;
    }

    /**
     * @return array
     */
    public function getIdShops()
    {
        return $this->idShops;
    }

    /**
     * @param array $idShops
     *
     * @return CreateConfigurationModel
     */
    public function setIdShops($idShops)
    {
        if (empty($idShops)) {
            $idShops = [];
        }
        $this->idShops = array_map(function ($idShop) {
            return (int) $idShop;
        }, $idShops);

        return $this;
    }

    /**
     * @return int
     */
    public function getIdLanguage()
    {
        return $this->idLanguage;
    }

    /**
     * @param int $idLanguage
     *
     * @return CreateConfigurationModel
     */
    public function setIdLanguage($idLanguage)
    {
        $this->idLanguage = (int) $idLanguage;

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
     * @return CreateConfigurationModel
     */
    public function setMessage($message)
    {
        $this->message = $message;

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
     * @return CreateConfigurationModel
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param mixed $subtitle
     *
     * @return CreateConfigurationModel
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }
}
