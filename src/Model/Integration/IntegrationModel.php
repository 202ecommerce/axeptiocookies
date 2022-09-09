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

class IntegrationModel implements \JsonSerializable
{
    protected $clientId;

    protected $cookiesVersion;

    protected $jsonCookieName;

    protected $allVendorsCookieName;

    protected $authorizedVendorsCookieName;

    /**
     * @var StepModel
     */
    protected $moduleStep;

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     *
     * @return IntegrationModel
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCookiesVersion()
    {
        return $this->cookiesVersion;
    }

    /**
     * @param mixed $cookiesVersion
     *
     * @return IntegrationModel
     */
    public function setCookiesVersion($cookiesVersion)
    {
        $this->cookiesVersion = $cookiesVersion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getJsonCookieName()
    {
        return $this->jsonCookieName;
    }

    /**
     * @param mixed $jsonCookieName
     *
     * @return IntegrationModel
     */
    public function setJsonCookieName($jsonCookieName)
    {
        $this->jsonCookieName = $jsonCookieName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAllVendorsCookieName()
    {
        return $this->allVendorsCookieName;
    }

    /**
     * @param mixed $allVendorsCookieName
     *
     * @return IntegrationModel
     */
    public function setAllVendorsCookieName($allVendorsCookieName)
    {
        $this->allVendorsCookieName = $allVendorsCookieName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorizedVendorsCookieName()
    {
        return $this->authorizedVendorsCookieName;
    }

    /**
     * @param mixed $authorizedVendorsCookieName
     *
     * @return IntegrationModel
     */
    public function setAuthorizedVendorsCookieName($authorizedVendorsCookieName)
    {
        $this->authorizedVendorsCookieName = $authorizedVendorsCookieName;

        return $this;
    }

    /**
     * @return StepModel
     */
    public function getModuleStep()
    {
        return $this->moduleStep;
    }

    /**
     * @param StepModel $moduleStep
     *
     * @return IntegrationModel
     */
    public function setModuleStep($moduleStep)
    {
        $this->moduleStep = $moduleStep;

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function __set_state($array)
    {
        $obj = new IntegrationModel();
        $obj->setClientId($array['clientId']);
        $obj->setCookiesVersion($array['cookiesVersion']);
        $obj->setJsonCookieName($array['jsonCookieName']);
        $obj->setAllVendorsCookieName($array['allVendorsCookieName']);
        $obj->setAuthorizedVendorsCookieName($array['authorizedVendorsCookieName']);
        $obj->setModuleStep($array['moduleStep']);

        return $obj;
    }

    public function toArray()
    {
        return [
            'clientId' => $this->getClientId(),
            'cookiesVersion' => $this->getCookiesVersion(),
            'jsonCookieName' => $this->getJsonCookieName(),
            'allVendorsCookieName' => $this->getAllVendorsCookieName(),
            'authorizedVendorsCookieName' => $this->getAuthorizedVendorsCookieName(),
            'moduleStep' => empty($this->getModuleStep()) ? [] : $this->getModuleStep()->toArray(),
        ];
    }
}
