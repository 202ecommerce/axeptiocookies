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
