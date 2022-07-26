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
     * @return CreateConfigurationModel
     */
    public function setIdLanguage($idLanguage)
    {
        $this->idLanguage = $idLanguage;

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
