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

if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesAddon\API\Response\Object\Configuration;

class ListConfigurationModel implements \JsonSerializable
{
    /**
     * @var int
     */
    protected $idObject;

    /**
     * @var string
     */
    protected $idProject;

    protected $idConfiguration;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var array
     */
    protected $idShops;

    /**
     * @var int
     */
    protected $idLanguage;

    /**
     * @return int
     */
    public function getIdObject()
    {
        return $this->idObject;
    }

    /**
     * @param int $idObject
     *
     * @return ListConfigurationModel
     */
    public function setIdObject($idObject)
    {
        $this->idObject = $idObject;

        return $this;
    }

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
     * @return ListConfigurationModel
     */
    public function setIdProject($idProject)
    {
        $this->idProject = $idProject;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdConfiguration()
    {
        return $this->idConfiguration;
    }

    /**
     * @param mixed $idConfiguration
     *
     * @return ListConfigurationModel
     */
    public function setIdConfiguration($idConfiguration)
    {
        $this->idConfiguration = $idConfiguration;

        return $this;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param Configuration $configuration
     *
     * @return ListConfigurationModel
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;

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
     * @return ListConfigurationModel
     */
    public function setIdShops($idShops)
    {
        $this->idShops = $idShops;

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
     * @return ListConfigurationModel
     */
    public function setIdLanguage($idLanguage)
    {
        $this->idLanguage = $idLanguage;

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
