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

namespace AxeptiocookiesAddon\API\Response\Object;

class Project extends AbstractObject
{
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
