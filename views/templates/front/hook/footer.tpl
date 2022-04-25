{if !empty($integration)}
  <script>
    window.axeptioSettings = {
      //<![CDATA[
      clientId: "{$integration.clientId}",
      cookiesVersion: "{$integration.cookiesVersion}",
      jsonCookieName: "{$integration.jsonCookieName}",
      allVendorsCookieName: "{$integration.allVendorsCookieName}",
      authorizedVendorsCookieName: "{$integration.authorizedVendorsCookieName}"
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
