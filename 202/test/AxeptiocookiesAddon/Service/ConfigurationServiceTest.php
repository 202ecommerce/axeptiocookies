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
use AxeptiocookiesAddon\AxeptioBaseTestCase;
use AxeptiocookiesAddon\Entity\AxeptioConfiguration;
use AxeptiocookiesAddon\Entity\AxeptioModuleConfiguration;
use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Model\EditConfigurationModel;
use AxeptiocookiesAddon\Validator\ConfigurationValidatorException;

class ConfigurationServiceTest extends AxeptioBaseTestCase
{
    /**
     * @var int
     */
    protected static $createdConfiguration;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::truncateTables();
    }

    public function testCreateConfigurationValid()
    {
        $createConfigurationModel = (new CreateConfigurationModel())
            ->setIdProject(getenv('TEST_ID_PROJECT'))
            ->setIdConfiguration(getenv('TEST_ID_CONFIGURATION'))
            ->setIdLanguage(1)
            ->setIdShops([1])
            ->setTitle('Test title')
            ->setSubtitle('Test subtitle');

        $result = $this->configurationService->createConfiguration($createConfigurationModel);

        $this->assertNotEmpty($result);

        $configuration = new AxeptioConfiguration($result);
        $this->assertNotEmpty($configuration->toArray());

        static::$createdConfiguration = (int) $result;
    }

    /**
     * @depends testCreateConfigurationValid
     */
    public function testCreateConfigurationSameShopLang()
    {
        $createConfigurationModel = (new CreateConfigurationModel())
            ->setIdProject(getenv('TEST_ID_PROJECT'))
            ->setIdConfiguration(getenv('TEST_ID_CONFIGURATION'))
            ->setIdLanguage(1)
            ->setIdShops([1]);

        $this->expectException(ConfigurationValidatorException::class);
        $this->configurationService->createConfiguration($createConfigurationModel);
    }

    public function testCreateConfigurationValidationError()
    {
        $createConfigurationModel = (new CreateConfigurationModel())
            ->setIdProject(getenv('TEST_ID_PROJECT'))
            ->setIdConfiguration('')
            ->setIdLanguage(1)
            ->setIdShops([1]);

        $this->expectException(ConfigurationValidatorException::class);
        $this->configurationService->createConfiguration($createConfigurationModel);
    }

    /**
     * @depends testCreateConfigurationValid
     */
    public function testEditConfigurationSave()
    {
        if (empty(self::$createdConfiguration)) {
            $this->markTestSkipped('Created configuration empty');
        }

        $editConfigurationModel = $this->getEditConfigurationObject();

        $result = $this->configurationService->editConfiguration($editConfigurationModel);
        $configuration = new AxeptioConfiguration(static::$createdConfiguration);
        $selectedConfigurations = $this->moduleService->getSelectedModulesByIdConfiguration($configuration->id);

        $this->assertNotEmpty($result);
        $this->assertEquals(2, $configuration->id_lang);
        $this->assertNotEmpty($selectedConfigurations);

        $idModuleConfiguration = $selectedConfigurations[0][AxeptioModuleConfiguration::$definition['primary']];
        $moduleConfiguration = new AxeptioModuleConfiguration($idModuleConfiguration);
        $this->assertNotEmpty($moduleConfiguration->id);
        $this->assertNotEmpty($moduleConfiguration->toArray());
    }

    /**
     * @dataProvider getTestEditConfigurationErrorDataProvider
     * @depends      testCreateConfigurationValid
     */
    public function testEditConfigurationSaveError(callable $editConfigSetter, $expectedExceptionMessage)
    {
        if (empty(self::$createdConfiguration)) {
            $this->markTestSkipped('Created configuration empty');
        }

        $editConfigurationModel = $editConfigSetter($this->getEditConfigurationObject());

        $this->expectExceptionMessage($expectedExceptionMessage);
        $this->configurationService->editConfiguration($editConfigurationModel);
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

        $this->configurationService->getById(-1);
    }

    /**
     * @depends testCreateConfigurationValid
     */
    public function testDeleteConfigurationValid()
    {
        $deleteResult = $this->configurationService->deleteById(static::$createdConfiguration);
        $this->assertNotEmpty($deleteResult);
    }

    protected function getEditConfigurationObject()
    {
        $configuration = (new Configuration())
            ->build([
                'identifier' => getenv('TEST_ID_CONFIGURATION'),
                'language' => 'fr',
                'name' => 'projet test module axeptio-fr',
                'title' => 'French Projet Test module Axeptio Cookies'
            ]);

        return (new EditConfigurationModel())
            ->setIdObject(static::$createdConfiguration)
            ->setIdProject(getenv('TEST_ID_PROJECT'))
            ->setConfiguration($configuration)
            ->setLanguage(\Language::getLanguage(2))
            ->setShops([\Shop::getShop(1)])
            ->setProject((new Project())->build(
                [
                    'projectId' => getenv('TEST_ID_PROJECT'),
                    'cookies' => [
                        [
                            'identifier' => getenv('TEST_ID_CONFIGURATION'),
                            'language' => 'fr',
                            'name' => 'projet test module axeptio-fr',
                            'title' => 'French Projet Test module Axeptio Cookies'
                        ]
                    ]
                ]
            ))
            ->setPaint(false)
            ->setIllustration('test.png')
            ->setModules([
                [
                    'name' => 'ps_shoppingcart',
                    'checked' => 'true',
                ]
            ]);
    }

    public function getTestEditConfigurationErrorDataProvider()
    {
        return [
            [function (EditConfigurationModel $editConfigurationModel) {
                return $editConfigurationModel->setIdObject(0);
            }, 'Object ID is not valid'],
            [function (EditConfigurationModel $editConfigurationModel) {
                return $editConfigurationModel->setIdProject('');
            }, 'Project ID is not valid'],
            [function (EditConfigurationModel $editConfigurationModel) {
                return $editConfigurationModel->setShops([]);
            }, 'Shops are not selected'],
            [function (EditConfigurationModel $editConfigurationModel) {
                return $editConfigurationModel->setLanguage(\Language::getLanguage(0));
            }, 'Language is not selected'],
        ];
    }
}
