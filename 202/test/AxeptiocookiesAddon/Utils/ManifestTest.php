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

use AxeptiocookiesAddon\AxeptioBaseTestCase;
use AxeptiocookiesAddon\Validator\ConfigurationValidatorException;

class ManifestTest extends AxeptioBaseTestCase
{
    public function testManifest()
    {
        $this->createManifest();
        $viteVariables = (new GetViteVariablesUtils())->getViteVariables();

        $this->assertNotEmpty($viteVariables);
        $this->assertNotEmpty($viteVariables['cssBuild']);
        $this->assertNotEmpty($viteVariables['jsBuild']);
        $this->assertNotEmpty($viteVariables['jsEntry']);
    }

    public function testManifestSpecific()
    {
        $this->createManifest();
        $viteVariables = (new GetViteVariablesUtils())->getViteVariables('src/admin/js/main.ts');

        $this->assertNotEmpty($viteVariables);
        $this->assertNotEmpty($viteVariables['cssBuild']);
        $this->assertEmpty($viteVariables['jsBuild']);
        $this->assertNotEmpty($viteVariables['jsEntry']);
    }

    /**
     * @return void
     * @throws \Exception
     * @expectedException \Exception
     */
    public function testManifestError()
    {
        $file = _PS_MODULE_DIR_ . 'axeptiocookies/views/manifest.json';
        if (file_exists($file)) {
            unlink($file);
        }
        $this->expectExceptionMessage('manifest.json not exist');
        (new GetViteVariablesUtils())->getViteVariables('src/admin/js/main.ts');
    }

    protected function createManifest()
    {
        $file = _PS_MODULE_DIR_ . 'axeptiocookies/views/manifest.json';
        if (file_exists($file)) {
            unlink($file);
        }
        file_put_contents($file, '{
  "src/admin/js/main.css": {
    "file": "css/test.css",
    "src": "src/admin/js/main.css"
  },
  "src/admin/js/main.ts": {
    "css": [
      "css/test.css"
    ],
    "file": "js/test.js",
    "isEntry": true,
    "src": "src/admin/js/main.ts"
  }
}
        ');

    }
}