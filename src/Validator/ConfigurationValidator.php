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

namespace AxeptiocookiesAddon\Validator;

use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Model\EditConfigurationModel;
use AxeptiocookiesAddon\Repository\ConfigurationRepository;
use AxeptiocookiesClasslib\Utils\Translate\TranslateTrait;
use Context;
use Shop;

class ConfigurationValidator
{
    use TranslateTrait;

    /**
     * @var ConfigurationRepository
     */
    protected $configurationRepository;

    /**
     * @param ConfigurationRepository $configurationRepository
     */
    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function validateCreateConfiguration(CreateConfigurationModel $configurationModel)
    {
        if (empty($configurationModel->getIdProject())) {
            throw new ConfigurationValidatorException($this->l('Project ID is not valid', $this->getClassShortName()));
        }

        if (empty($configurationModel->getIdConfiguration())) {
            throw new ConfigurationValidatorException($this->l('Configuration is not valid', $this->getClassShortName()));
        }

        if (empty($configurationModel->getIdShops())) {
            throw new ConfigurationValidatorException($this->l('Shops are not selected', $this->getClassShortName()));
        }

        if (empty($configurationModel->getIdLanguage())) {
            throw new ConfigurationValidatorException($this->l('Language is not selected', $this->getClassShortName()));
        }

        foreach ($configurationModel->getIdShops() as $idShop) {
            $configurations = $this->configurationRepository->getConfigurationsByShopLang(
                $idShop,
                $configurationModel->getIdLanguage()
            );
            if (!empty($configurations)) {
                $shop = new Shop((int) $idShop, Context::getContext()->language->id);
                throw new ConfigurationValidatorException(sprintf($this->l('Association for shop "%s" already exists', $this->getClassShortName()), $shop->name));
            }
        }

        return true;
    }

    public function validateEditConfiguration(EditConfigurationModel $configurationModel)
    {
        if (empty($configurationModel->getIdObject())) {
            throw new ConfigurationValidatorException($this->l('Object ID is not valid', $this->getClassShortName()));
        }

        if (empty($configurationModel->getIdProject())) {
            throw new ConfigurationValidatorException($this->l('Project ID is not valid', $this->getClassShortName()));
        }

        if (empty($configurationModel->getConfiguration()->getId())) {
            throw new ConfigurationValidatorException($this->l('Configuration is not valid', $this->getClassShortName()));
        }

        if (empty($configurationModel->getShops())) {
            throw new ConfigurationValidatorException($this->l('Shops are not selected', $this->getClassShortName()));
        }

        if (empty($configurationModel->getLanguage())) {
            throw new ConfigurationValidatorException($this->l('Language is not selected', $this->getClassShortName()));
        }

        foreach ($configurationModel->getShops() as $shop) {
            $configurations = $this->configurationRepository->getConfigurationsByShopLang(
                $shop['id_shop'],
                $configurationModel->getLanguage()['id_lang'],
                $configurationModel->getIdObject()
            );
            if (!empty($configurations)) {
                $shop = new Shop((int) $shop['id_shop'], Context::getContext()->language->id);
                throw new ConfigurationValidatorException(sprintf($this->l('Association for shop "%s" already exists', $this->getClassShortName()), $shop->name));
            }
        }

        return true;
    }
}
