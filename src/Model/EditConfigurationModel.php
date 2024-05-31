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
     * @var string|null
     */
    protected $illustration;

    /**
     * @var bool
     */
    protected $is_consent_v2 = false;

    /**
     * @var bool
     */
    protected $analytics_storage = false;

    /**
     * @var bool
     */
    protected $ad_storage = false;

    /**
     * @var bool
     */
    protected $ad_user_data = false;

    /**
     * @var bool
     */
    public $ad_personalization = false;

    /**
     * @var bool
     */
    public $has_illustration = false;

    /**
     * @var bool
     */
    public $paint = true;

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
        $this->idObject = (int) $idObject;

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

    /**
     * @return bool
     */
    public function getIsConsentV2()
    {
        return $this->is_consent_v2;
    }

    /**
     * @param bool $is_consent_v2
     *
     * @return EditConfigurationModel
     */
    public function setIsConsentV2($is_consent_v2)
    {
        $this->is_consent_v2 = $is_consent_v2;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAnalyticsStorage()
    {
        return $this->analytics_storage;
    }

    /**
     * @param bool $analytics_storage
     *
     * @return EditConfigurationModel
     */
    public function setAnalyticsStorage($analytics_storage)
    {
        $this->analytics_storage = $analytics_storage;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAdStorage()
    {
        return $this->ad_storage;
    }

    /**
     * @param bool $ad_storage
     *
     * @return EditConfigurationModel
     */
    public function setAdStorage($ad_storage)
    {
        $this->ad_storage = $ad_storage;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAdUserData()
    {
        return $this->ad_user_data;
    }

    /**
     * @param bool $ad_user_data
     *
     * @return EditConfigurationModel
     */
    public function setAdUserData($ad_user_data)
    {
        $this->ad_user_data = $ad_user_data;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAdPersonalization()
    {
        return $this->ad_personalization;
    }

    /**
     * @param bool $ad_personalization
     *
     * @return EditConfigurationModel
     */
    public function setAdPersonalization($ad_personalization)
    {
        $this->ad_personalization = $ad_personalization;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIllustration()
    {
        return $this->illustration;
    }

    /**
     * @param string|null $illustration
     *
     * @return EditConfigurationModel
     */
    public function setIllustration($illustration)
    {
        $this->illustration = $illustration;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasIllustration()
    {
        return $this->has_illustration;
    }

    /**
     * @param bool $has_illustration
     *
     * @return EditConfigurationModel
     */
    public function setHasIllustration($has_illustration)
    {
        $this->has_illustration = $has_illustration;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPaint()
    {
        return $this->paint;
    }

    /**
     * @param bool $paint
     *
     * @return EditConfigurationModel
     */
    public function setPaint($paint)
    {
        $this->paint = $paint;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
