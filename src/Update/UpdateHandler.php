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

namespace AxeptiocookiesAddon\Update;

use AxeptiocookiesAddon\API\Response\Object\Configuration;
use AxeptiocookiesAddon\Model\CreateConfigurationModel;
use AxeptiocookiesAddon\Service\ConfigurationService;
use AxeptiocookiesAddon\Service\ProjectService;

class UpdateHandler
{
    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * @var ConfigurationService
     */
    protected $configurationService;

    /**
     * @param ProjectService $projectService
     * @param ConfigurationService $configurationService
     */
    public function __construct(ProjectService $projectService, ConfigurationService $configurationService)
    {
        $this->projectService = $projectService;
        $this->configurationService = $configurationService;
    }

    /**
     * @param string $projectId
     * @param string $versionId
     * @param int|null $idShop
     * @param int $idLang
     *
     * @return bool
     */
    public function createLangShopConfigurationFromParams($projectId, $versionId, $idShop, $idLang)
    {
        if (empty($projectId) || empty($versionId) || empty($idShop) || empty($idLang)) {
            return false;
        }

        $project = $this->projectService->getCookiesByProjectId($projectId);

        if (empty($project->getIdProject())) {
            return false;
        }

        $configuration = null;
        /** @var Configuration $projectConfiguration */
        foreach ($project->getConfigurations() as $projectConfiguration) {
            if ($projectConfiguration->getName() == $versionId) {
                $configuration = $projectConfiguration;
                break;
            }
        }

        if (is_null($configuration)) {
            return false;
        }

        $createConfiguration = (new CreateConfigurationModel())
            ->setIdProject($projectId)
            ->setIdConfiguration($configuration->getId())
            ->setIdLanguage($idLang)
            ->setIdShops([$idShop]);

        return $this->configurationService->createConfiguration($createConfiguration);
    }
}
