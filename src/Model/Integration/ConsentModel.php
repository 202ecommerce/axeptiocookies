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

if (!defined('_PS_VERSION_')) {
    exit;
}

class ConsentModel implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $analyticsStorage = 'denied';

    /**
     * @var string
     */
    protected $adStorage = 'denied';

    /**
     * @var string
     */
    protected $adUserData = 'denied';

    /**
     * @var string
     */
    protected $adPersonalization = 'denied';

    /**
     * @var int
     */
    protected $waitForUpdate = 500;

    /**
     * @return string
     */
    public function getAnalyticsStorage()
    {
        return $this->analyticsStorage;
    }

    /**
     * @param string $analyticsStorage
     *
     * @return ConsentModel
     */
    public function setAnalyticsStorage($analyticsStorage)
    {
        $this->analyticsStorage = $analyticsStorage;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdStorage()
    {
        return $this->adStorage;
    }

    /**
     * @param string $adStorage
     *
     * @return ConsentModel
     */
    public function setAdStorage($adStorage)
    {
        $this->adStorage = $adStorage;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdUserData()
    {
        return $this->adUserData;
    }

    /**
     * @param string $adUserData
     *
     * @return ConsentModel
     */
    public function setAdUserData($adUserData)
    {
        $this->adUserData = $adUserData;

        return $this;
    }

    /**
     * @return string
     */
    public function getAdPersonalization()
    {
        return $this->adPersonalization;
    }

    /**
     * @param string $adPersonalization
     *
     * @return ConsentModel
     */
    public function setAdPersonalization($adPersonalization)
    {
        $this->adPersonalization = $adPersonalization;

        return $this;
    }

    /**
     * @return int
     */
    public function getWaitForUpdate()
    {
        return $this->waitForUpdate;
    }

    /**
     * @param int $waitForUpdate
     *
     * @return ConsentModel
     */
    public function setWaitForUpdate($waitForUpdate)
    {
        $this->waitForUpdate = $waitForUpdate;

        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function __set_state($array)
    {
        $obj = new ConsentModel();
        $obj->setAdStorage(empty($array['adStorage']) ? 'denied' : $array['adStorage']);
        $obj->setAdUserData(empty($array['adUserData']) ? 'denied' : $array['adUserData']);
        $obj->setAnalyticsStorage(empty($array['analyticsStorage']) ? 'denied' : $array['analyticsStorage']);
        $obj->setAdPersonalization(empty($array['adPersonalization']) ? 'denied' : $array['adPersonalization']);
        $obj->setWaitForUpdate(empty($array['waitForUpdate']) ? 500 : $array['waitForUpdate']);

        return $obj;
    }

    public function toArray()
    {
        return [
            'analytics_storage' => $this->getAnalyticsStorage(),
            'ad_storage' => $this->getAdStorage(),
            'ad_user_data' => $this->getAdUserData(),
            'ad_personalization' => $this->getAdPersonalization(),
            'wait_for_update' => $this->getWaitForUpdate(),
        ];
    }
}
