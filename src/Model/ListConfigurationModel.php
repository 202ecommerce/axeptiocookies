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

namespace AxeptiocookiesAddon\Model;

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
