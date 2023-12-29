#!/bin/bash

set +ex

ls -la
cd modules/axeptiocookies

php -v | grep 5.6 && echo "deb http://archive.debian.org/debian stretch main" > /etc/apt/sources.list
php -v | grep 5.6 && echo "deb-src http://archive.debian.org/debian stretch main" >> /etc/apt/sources.list
php -v | grep 5.6 && echo "deb http://archive.debian.org/debian stretch-backports main" >> /etc/apt/sources.list
php -v | grep 5.6 && echo "deb-src http://archive.debian.org/debian-security stretch/updates main" >> /etc/apt/sources.list
apt-get update && apt-get install wget git zip unzip xmlstarlet -y
wget https://composer.github.io/installer.sig -O - -q | tr -d '\n' > installer.sig
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === file_get_contents('installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php'); unlink('installer.sig');"

CI_PROJECT_NAME=axeptiocookies
CI_PROJECT_DIR=/var/www/html/modules/axeptiocookies
MODULE_VERSION=$(xmlstarlet sel -t -v '/project/property[@name="TARGETVERSION"]/@value' 202/build.xml)
find ./ -type f -exec sed -i "s/@version@/$MODULE_VERSION/g" {} +
php composer.phar global require prestashop/autoindex
~/.composer/vendor/bin/autoindex --exclude=202
rm -f composer.lock
find ./vendor -mindepth 1 ! -regex '^./vendor/totpsclasslib\(/.*\)?' -delete
php composer.phar remove phpstan/phpstan phpunit/phpunit prestashop/php-dev-tools prestashop/header-stamp --no-progress --dev --no-install --no-update
php composer.phar install --no-dev --optimize-autoloader --classmap-authoritative
rm 202 node_modules composer.* node_modules _dev .git tests var -Rf
rm docker-compose.yml browserlist .stylelintignore .editorconfig babel.config.js webpack.config.js postcss.config.js cache.properties sonar-project.properties config_fr.xml composer.json composer.lock composer.phar .gitignore .browserlistrc .eslintrc.js .postcssrc.js babel.config.js vue.config.js package.json package-lock.json .php-cs-fixer.dist.php .php_cs.cache .php-cs-fixer.cache .gitlab-ci.yml before_autoload.sh Makefile Readme.md views/_dev -Rf
[ -d ../../packages ] || mkdir ../../packages
rm -Rf ../../packages/$CI_PROJECT_NAME
mkdir ../../packages/$CI_PROJECT_NAME
cd ../
zip -9 -r -q --exclude=\*.DS_Store\* --exclude=\*._.DS_Store\* --exclude=\*__MACOSX\* --exclude=\*.buildpath\*  --exclude=\*.dropbox\* --exclude=\*.git\* --exclude=\*.idea\* --exclude=\*.project\* --exclude=\*.sass-cache\* --exclude=\*.settings\* --exclude=\*.svn\* --exclude=\*config.codekit\* --exclude=\*desktop.ini\* --exclude=\*nbproject\* --exclude=\*.log --exclude=$CI_PROJECT_NAME/config.xml --exclude=$CI_PROJECT_NAME/config_\*.xml $CI_PROJECT_DIR/../../packages/$CI_PROJECT_NAME/$CI_PROJECT_NAME.zip ./$CI_PROJECT_NAME
cd $CI_PROJECT_DIR/../../packages/$CI_PROJECT_NAME
unzip $CI_PROJECT_NAME.zip
cd $CI_PROJECT_DIR/../../packages/$CI_PROJECT_NAME/$CI_PROJECT_NAME
find . -type f -exec md5sum "{}" + > ../$CI_PROJECT_NAME.md5
cd $CI_PROJECT_DIR/../../packages/$CI_PROJECT_NAME
rm -Rf $CI_PROJECT_DIR
mkdir $CI_PROJECT_DIR
cp *.zip $CI_PROJECT_DIR
cp *.md5 $CI_PROJECT_DIR
