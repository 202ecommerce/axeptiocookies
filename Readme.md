## Axeptio Official Module for PrestaShop

[![Coding Standart](https://github.com/202ecommerce/axeptiocookies/actions/workflows/php.yml/badge.svg?branch=develop)](https://github.com/202ecommerce/axeptiocookies/actions/workflows/php.yml)

[![Unit tests](https://github.com/202ecommerce/axeptiocookies/actions/workflows/phpunit.yml/badge.svg?branch=develop)](https://github.com/202ecommerce/axeptiocookies/actions/workflows/phpunit.yml)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=202ecommerce_axeptiocookies&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=202ecommerce_axeptiocookies)

## About

New rules for cookies: you need to collect consent for your cookies. 
Be a step ahead with our innovative solution, which is fun and respectful of your users!

## Installation

To install module on PrestaShop, download zip package form [Product page on PrestaShop Addons](https://addons.prestashop.com/en/legal/48896-cookie-consent-by-axeptio.html).

This module contain composer.json file. If you clone or download the module from github
repository, run the ```composer install``` from the root module folder.

See the [composer documentation](https://getcomposer.org/doc/) to learn more about the composer.json file.

## Compiling assets
**For development**

We use _Webpack_ to compile our javascript and scss files.  
In order to compile those files, you must :
1. have _Node 10+_ installed locally
2. run `npm install` in the root folder to install dependencies
3. then run `npm run watch` to compile assets and watch for file changes

**For production**

Run `npm run build` to compile for production.  
Files are minified, `console.log` and comments dropped.

## Cs fixer

`php vendor/bin/php-cs-fixer fix --no-interaction --dry-run --diff` to show code lines to be fixed.

`php vendor/bin/php-cs-fixer fix` to fix automatically all files.