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
