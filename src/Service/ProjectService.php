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
