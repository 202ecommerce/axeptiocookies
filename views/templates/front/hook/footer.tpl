{**
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
 *}
{if !empty($integration)}
  <script>
    window.axeptioSettings = {
      //<![CDATA[
      clientId: "{$integration.clientId|escape:'htmlall':'UTF-8'}",
      cookiesVersion: "{$integration.cookiesVersion|escape:'htmlall':'UTF-8'}",
      jsonCookieName: "{$integration.jsonCookieName|escape:'htmlall':'UTF-8'}",
      allVendorsCookieName: "{$integration.allVendorsCookieName|escape:'htmlall':'UTF-8'}",
      authorizedVendorsCookieName: "{$integration.authorizedVendorsCookieName|escape:'htmlall':'UTF-8'}"
      //]]>
    };

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
      var currentCookiesConfig = window.axeptioSDK.userPreferencesManager.choices;
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
        if (Object.keys(window.axeptioSDK.userPreferencesManager.choices).length === 0) {
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
            window.location.reload();
            break;
          }
        }
      });
    });
  </script>
{/if}
