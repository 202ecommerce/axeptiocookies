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