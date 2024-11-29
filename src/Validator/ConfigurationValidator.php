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

namespace AxeptiocookiesAddon\Validator;

if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Model\EditConfigurationModel;
use AxeptiocookiesAddon\Repository\ConfigurationRepository;
use AxeptiocookiesClasslib\Utils\Translate\TranslateTrait;

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
                $shop = new \Shop((int) $idShop, \Context::getContext()->language->id);
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
                $shop = new \Shop((int) $shop['id_shop'], \Context::getContext()->language->id);
                throw new ConfigurationValidatorException(sprintf($this->l('Association for shop "%s" already exists', $this->getClassShortName()), $shop->name));
            }
        }

        return true;
    }
}
