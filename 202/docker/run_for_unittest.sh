#!/bin/bash

set -e
set -x

/etc/init.d/mariadb start

echo "Init and install of Axeptio module"

php /var/www/html/bin/console prestashop:module install axeptiocookies -e prod

cd /var/www/html/modules/axeptiocookies/

echo "Launch of unit tests"

vendor/bin/phpunit -c 202/phpunit.xml

chown www-data:www-data /var/www/html/var -Rf