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

use AxeptiocookiesAddon\API\Response\Object\Configuration;
use AxeptiocookiesAddon\API\Response\Object\Project;

class EditConfigurationModel implements \JsonSerializable
{
    /**
     * @var int
     */
    protected $idObject;

    /**
     * @var string
     */
    protected $idProject;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var array
     */
    protected $shops;

    /**
     * @var array
     */
    protected $language;

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
     * @var array
     */
    protected $modules = [];

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
     * @return EditConfigurationModel
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
     * @return EditConfigurationModel
     */
    public function setIdProject($idProject)
    {
        $this->idProject = $idProject;

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
     * @return EditConfigurationModel
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @return array
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * @param array $shops
     *
     * @return EditConfigurationModel
     */
    public function setShops($shops)
    {
        $this->shops = $shops;

        return $this;
    }

    /**
     * @return array
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param array $language
     *
     * @return EditConfigurationModel
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @param array $modules
     *
     * @return EditConfigurationModel
     */
    public function setModules($modules)
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     *
     * @return EditConfigurationModel
     */
    public function setProject($project)
    {
        $this->project = $project;

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
     * @return EditConfigurationModel
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
     * @return EditConfigurationModel
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
     * @return EditConfigurationModel
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
