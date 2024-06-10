{**
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
 *}

{assign var="vitedev" value=true}

{if $vitedev}
  <script type="module" src="http://localhost:8000/@vite/client"></script>
{else}
  <script type="module" crossorigin src="{$jsEntry|escape:'htmlall':'UTF-8'}"></script>
  {foreach $jsBuild as $js}
    <link rel="modulepreload" href="{$js|escape:'htmlall':'UTF-8'}">
  {/foreach}
  {foreach $cssBuild as $css}
    <link rel="stylesheet" href="{$css|escape:'htmlall':'UTF-8'}">
  {/foreach}
{/if}

<div class="axeptioApp">
  <div id="axeptio-configuration"></div>
</div>
{if $vitedev}
  <script type="module" src="http://localhost:8000/src/admin/js/main.ts"></script>
{/if}

