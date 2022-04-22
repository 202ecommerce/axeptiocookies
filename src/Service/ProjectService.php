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

namespace AxeptiocookiesAddon\Service;

use AxeptiocookiesAddon\API\Client\Client;
use AxeptiocookiesAddon\API\Request\ProjectRequest;
use AxeptiocookiesAddon\API\Response\Object\Configuration;
use AxeptiocookiesAddon\API\Response\Object\Project;
use Exception;

class ProjectService
{
    protected static $projects = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $projectId
     *
     * @return Project
     */
    public function getCookiesByProjectId($projectId)
    {
        try {
            if (!empty(static::$projects[$projectId])) {
                return static::$projects[$projectId];
            }

            $request = new ProjectRequest();
            $request->setIdProject($projectId);

            static::$projects[$projectId] = $this->client->call($request);

            return static::$projects[$projectId];
        } catch (Exception $exception) {
            return new Project();
        }
    }

    public function getConfigurationByIdProjectConfiguration($idProject, $idConfiguration)
    {
        $project = $this->getCookiesByProjectId($idProject);

        if ($project === false) {
            return null;
        }

        /** @var Configuration $configuration */
        foreach ($project->getConfigurations() as $configuration) {
            if ($configuration->getId() == $idConfiguration) {
                return $configuration;
            }
        }

        return null;
    }
}
