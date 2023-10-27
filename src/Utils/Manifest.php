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

namespace AxeptiocookiesAddon\Utils;

class Manifest
{
    private $manifest;
    private $baseUri;

    public function __construct($manifestFile, $baseUri)
    {
        if (!file_exists(realpath($manifestFile))) {
            throw new \Exception("Manifest file does not exist: $manifestFile");
        }

        try {
            $this->manifest = json_decode(
                \Tools::file_get_contents($manifestFile),
                true
            );
        } catch (\Exception $errorMessage) {
            throw new \Exception("Failed loading manifest: $errorMessage");
        }

        if (!parse_url($baseUri)) {
            throw new \Exception("Failed to parse URL: $baseUri");
        }

        $this->baseUri = $baseUri;
    }

    /**
     * @param string $entrypoint
     *
     * @return array
     */
    public function getEntrypoint($entrypoint)
    {
        return isset($this->manifest[$entrypoint]) ? [
            'url' => $this->getPath($this->manifest[$entrypoint]['file']),
        ] : [];
    }

    /**
     * Returns imports for a file listed in the manifest
     *
     * @param string $entrypoint
     *
     * @return array
     */
    public function getImports($entrypoint)
    {
        if (!isset($this->manifest[$entrypoint]) || !isset($this->manifest[$entrypoint]['imports']) || !is_array($this->manifest[$entrypoint]['imports'])) {
            return [];
        }

        return array_filter(
            array_map(function ($import) {
                return isset($this->manifest[$import]['file']) ? [
                    'url' => $this->getPath($this->manifest[$import]['file']),
                ] : [];
            }, $this->manifest[$entrypoint]['imports'], [])
        );
    }

    /**
     * @param string $entrypoint
     *
     * @return array
     */
    public function getStyles($entrypoint)
    {
        if (!isset($this->manifest[$entrypoint]) || !isset($this->manifest[$entrypoint]['css']) || !is_array($this->manifest[$entrypoint]['css'])) {
            return [];
        }

        return array_filter(
            array_map(function ($style) {
                return isset($style) ? [
                    'url' => $this->getPath($style),
                ] : [];
            }, $this->manifest[$entrypoint]['css'], [])
        );
    }

    /**
     * @param string $relativePath
     *
     * @return string
     */
    private function getPath($relativePath)
    {
        return $this->baseUri . $relativePath;
    }
}
