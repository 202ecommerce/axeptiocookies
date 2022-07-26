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

namespace AxeptiocookiesAddon\Service;

use AxeptiocookiesAddon\API\Response\Object\Configuration;
use AxeptiocookiesAddon\API\Response\Object\Project;
use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Model\EditConfigurationModel;
use AxeptiocookiesAddon\Utils\ServiceContainer;
use AxeptiocookiesAddon\Validator\ConfigurationValidatorException;
use PHPUnit\Framework\TestCase;

class ConfigurationServiceTest extends TestCase
{
    /**
     * @var int
     */
    protected static $createdConfiguration;

    /**
     * @var ConfigurationService
     */
    protected $configurationService;

    public function setUp()
    {
        parent::setUp();
        $this->configurationService = ServiceContainer::getInstance()->get(ConfigurationService::class);
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::truncateTables();
    }

    public function testCreateConfigurationValid()
    {
        $createConfigurationModel = (new CreateConfigurationModel())
            ->setIdProject('62500feea925ec04460954a9')
            ->setIdConfiguration('62500fefea9774f707035148')
            ->setIdLanguage(1)
            ->setIdShops([1]);

        $result = $this->configurationService->createConfiguration($createConfigurationModel);

        $this->assertNotEmpty($result);
        static::$createdConfiguration = (int)$result;
    }

    /**
     * @depends testCreateConfigurationValid
     */
    public function testCreateConfigurationSameShopLang()
    {
        $createConfigurationModel = (new CreateConfigurationModel())
            ->setIdProject('62500feea925ec04460954a9')
            ->setIdConfiguration('62500fefea9774f707035148')
            ->setIdLanguage(1)
            ->setIdShops([1]);

        $this->expectException(ConfigurationValidatorException::class);
        $this->configurationService->createConfiguration($createConfigurationModel);
    }

    public function testCreateConfigurationValidationError()
    {
        $createConfigurationModel = (new CreateConfigurationModel())
            ->setIdProject('62500feea925ec04460954a9')
            ->setIdConfiguration('')
            ->setIdLanguage(1)
            ->setIdShops([1]);

        $this->expectException(ConfigurationValidatorException::class);
        $result = $this->configurationService->createConfiguration($createConfigurationModel);
    }

    /**
     * @depends testCreateConfigurationValid
     */
    public function testEditConfigurationSave()
    {
        if (empty(self::$createdConfiguration)) {
            $this->markTestSkipped('Created configuration empty');
        }

        $configuration = (new Configuration())
            ->build([
                'identifier' => '62500fefea9774f707035148',
                'language' => 'fr',
                'name' => 'projet test module axeptio-fr',
                'title' => 'French Projet Test module Axeptio Cookies'
            ]);

        $editConfigurationModel = (new EditConfigurationModel())
            ->setIdObject(static::$createdConfiguration)
            ->setIdProject('62500feea925ec04460954a9')
            ->setConfiguration($configuration)
            ->setLanguage(\Language::getLanguage(2))
            ->setShops([\Shop::getShop(1)])
            ->setProject((new Project())->build(
                [
                    'projectId' => '62500feea925ec04460954a9',
                    'cookies' => [
                        [
                            'identifier' => '62500fefea9774f707035148',
                            'language' => 'fr',
                            'name' => 'projet test module axeptio-fr',
                            'title' => 'French Projet Test module Axeptio Cookies'
                        ]
                    ]
                ]
            ))
            ->setModules([
                [
                    'name' => 'ps_shoppingcart',
                    'checked' => 'true',
                ]
            ]);

        $result = $this->configurationService->editConfiguration($editConfigurationModel);
        $configuration = new AxeptioConfiguration(static::$createdConfiguration);

        $this->assertNotEmpty($result);
        $this->assertEquals($configuration->id_lang, 2);
    }

    public function testDeleteConfigurationNotValid()
    {
        $this->expectException(\PrestaShopException::class);
        $this->configurationService->deleteById(-1);
    }

    /**
     * @depends testCreateConfigurationValid
     */
    public function testGetAll()
    {
        $list = $this->configurationService->getAll();

        $this->assertNotEmpty($list);
    }

    /**
     * @depends testCreateConfigurationValid
     */
    public function testGetByIdSuccess()
    {
        $configuration = $this->configurationService->getById(static::$createdConfiguration);

        $this->assertEquals(static::$createdConfiguration, $configuration->getIdObject());
    }

    public function testGetByIdError()
    {
        $this->expectException(\PrestaShopException::class);

        $configuration = $this->configurationService->getById(-1);
    }

    /**
     * @depends testCreateConfigurationValid
     */
    public function testDeleteConfigurationValid()
    {
        $deleteResult = $this->configurationService->deleteById(static::$createdConfiguration);
        $this->assertNotEmpty($deleteResult);
    }

    private static function truncateTables()
    {
        \Db::getInstance()->delete(AxeptioConfiguration::$definition['table'], 1);
        \Db::getInstance()->delete(AxeptioModuleConfiguration::$definition['table'], 1);
    }
}
