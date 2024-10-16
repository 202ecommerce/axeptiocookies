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
{if !empty($integration)}
  <script>
    window.axeptioSettings = {
      //<![CDATA[
      clientId: "{$integration.clientId|escape:'htmlall':'UTF-8'}",
      triggerGTMEvents: {if $integration.triggerGtmEvents != 'update_only'}{if $integration.triggerGtmEvents == 'true'}true{else}false{/if}{else}"{$integration.triggerGtmEvents|escape:'htmlall':'UTF-8'}"{/if},
      {if !empty($integration.cookiesVersion)}
        cookiesVersion: "{$integration.cookiesVersion|escape:'htmlall':'UTF-8'}",
      {/if}
      platform: "{$integration.platform|escape:'htmlall':'UTF-8'}"
      //]]>
    };

    {if $integration.consent}
      window.axeptioSettings.googleConsentMode = {
          default: {$integration.consent|json_encode nofilter}
      };
    {/if}

    window.axeptioModuleStep = {$integration.moduleStep|json_encode nofilter};

    (function(d, s) {
      var t = d.getElementsByTagName(s)[0], e = d.createElement(s);
      e.async = true; e.src = "//static.axept.io/sdk.js";
      t.parentNode.insertBefore(e, t);
    })(document, "script");

    if (window.axeptioModuleStep !== null && !Array.isArray(window.axeptioModuleStep)) {
      (_axcb = window._axcb || []).push(function (sdk) {
        if(!sdk.cookiesConfig){
          return;
        }
        sdk.cookiesConfig.steps.splice(1, 0, window.axeptioModuleStep)
      });
    }

    (_axcb = window._axcb || []).push(function (sdk) {
      var currentCookiesConfig = typeof window.axeptioSDK.userPreferencesManager === "undefined"
          ? {}
          : window.axeptioSDK.userPreferencesManager.choices;
      var isCookiesSet = true;
      sdk.on('cookies:complete', function(choices) {
        currentCookiesConfig = Object.assign({
        }, choices);
        for (const [key, value] of Object.entries(currentCookiesConfig)) {
          if (typeof value === 'undefined') {
            currentCookiesConfig[key] = false;
          }
        }
      });
      sdk.on('ready', function() {
        var choices = typeof window.axeptioSDK.userPreferencesManager === "undefined"
            ? {}
            : window.axeptioSDK.userPreferencesManager.choices;
        if (Object.keys(choices).length === 0) {
          isCookiesSet = false;
        }
      });
      sdk.on('close', function(choices) {
        for (const [key, value] of Object.entries(choices)) {
          if (typeof value === 'undefined') {
            choices[key] = false;
          }
        }
        for (const [key, value] of Object.entries(choices)) {
          if (!isCookiesSet || (typeof currentCookiesConfig[key] === 'undefined' || currentCookiesConfig[key] !== value)) {
            // window.location.reload();
            break;
          }
        }
      });
    });
  </script>
{/if}
