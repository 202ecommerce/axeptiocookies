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
     * @param int $idShop
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
