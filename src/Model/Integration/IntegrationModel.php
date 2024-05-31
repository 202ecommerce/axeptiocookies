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

class IntegrationModel implements \JsonSerializable
{
    protected $clientId;

    protected $cookiesVersion;

    /**
     * @var StepModel
     */
    protected $moduleStep;

    /**
     * @var string
     */
    protected $platform = 'plugin-prestashop';

    /**
     * @var ConsentModel|null
     */
    protected $consent;

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

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     *
     * @return IntegrationModel
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return ConsentModel|null
     */
    public function getConsent()
    {
        return $this->consent;
    }

    /**
     * @param ConsentModel|null $consent
     *
     * @return IntegrationModel
     */
    public function setConsent($consent)
    {
        $this->consent = $consent;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function __set_state($array)
    {
        $obj = new IntegrationModel();
        $obj->setClientId($array['clientId']);
        $obj->setCookiesVersion($array['cookiesVersion']);
        $obj->setModuleStep($array['moduleStep']);
        $obj->setPlatform(empty($array['platform']) ? '' : $array['platform']);
        $obj->setConsent(empty($array['consent']) ? null : $array['consent']);

        return $obj;
    }

    public function toArray()
    {
        return [
            'clientId' => $this->getClientId(),
            'cookiesVersion' => $this->getCookiesVersion(),
            'moduleStep' => empty($this->getModuleStep()) ? [] : $this->getModuleStep()->toArray(),
            'platform' => $this->getPlatform(),
            'consent' => empty($this->getConsent()) ? null : $this->getConsent()->toArray(),
        ];
    }
}
