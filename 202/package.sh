#
# Copyright since 2022 Axeptio
#
# NOTICE OF LICENSE
#
# This source file is subject to the Academic Free License (AFL 3.0)
# that is bundled with this package in the file LICENSE.md.
# It is also available through the world-wide-web at this URL:
# https://opensource.org/licenses/AFL-3.0
# If you did not receive a copy of the license and are unable to
# obtain it through the world-wide-web, please send an email
# to tech@202-ecommerce.com so we can send you a copy immediately.
#
# @author    202 ecommerce <tech@202-ecommerce.com>
# @copyright 2022 Axeptio
# @license   https://opensource.org/licenses/AFL-3.0  Academic Free License (AFL 3.0)
#

rm -Rf views/_dev
rm -Rf .php_cs.dist
rm -Rf package.json
rm -Rf package-lock.json

if [ -f "composer.json" ]; then
    echo "Exécutution de composer pour ${TARGETNAME}"
    echo "Exécutution de composer pour ${BUILD}" >> /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.txt
    rm -Rf composer.lock
    find ./vendor -mindepth 1 ! -regex '^./vendor/totpsclasslib\(/.*\)?' -delete
    composer remove phpstan/phpstan phpunit/phpunit prestashop/php-dev-tools prestashop/header-stamp --no-progress --dev --no-install --no-update
    composer install --no-dev --optimize-autoloader --classmap-authoritative
fi