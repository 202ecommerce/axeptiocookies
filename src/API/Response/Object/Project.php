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

namespace AxeptiocookiesAddon\API\Response\Object;

if (!defined('_PS_VERSION_')) {
    exit;
}

use AxeptiocookiesClasslib\Utils\Translate\TranslateTrait;

class Project extends AbstractObject
{
    use TranslateTrait;

    /**
     * @var int
     */
    protected $idProject;

    /**
     * @var array
     */
    protected $configurations = [];

    public function build($json)
    {
        if (empty($json) || empty($json['projectId']) || !empty($json['isEmpty'])) {
            return $this;
        }

        $this->idProject = $json['projectId'];
        $this->configurations[] = $this->getDefaultConfiguration();
        if (!empty($json['cookies'])) {
            foreach ($json['cookies'] as $cookie) {
                $configuration = (new Configuration())->build($cookie);
                if (empty($configuration)) {
                    continue;
                }
                $this->configurations[] = $configuration;
            }
        }

        return $this;
    }

    protected function getDefaultConfiguration()
    {
        $defaultCookieName = $this->l('Automatic (Managed by Axeptio)', 'Project');

        return (new Configuration())
            ->build([
                'identifier' => null,
                'language' => null,
                'name' => \Tools::str2url($defaultCookieName),
                'title' => $defaultCookieName,
            ]);
    }

    /**
     * @return int
     */
    public function getIdProject()
    {
        return $this->idProject;
    }

    /**
     * @return array
     */
    public function getConfigurations()
    {
        return $this->configurations;
    }
}
