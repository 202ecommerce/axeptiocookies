#!/bin/bash

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

set +ex                     # immediate script fail off, echo off

SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"

ENVIRONMENT=$1
TARGETNAME=$2
TARGETBRANCH=$3
TARGETVERSION=$4
BUILD=$5

ADDONPATH=`pwd`
GITPATHFETCH=`git remote -v | grep '(fetch)'`
GITPATH=${6:-$GITPATHFETCH}

if [ "${ENVIRONMENT}" == "prod" ]; then
    echo -e "ENVIRONMENT: \e[32m${ENVIRONMENT} - $TARGETNAME\e[39m"
    echo "ENVIRONMENT: ${ENVIRONMENT} - $TARGETNAME" | tee /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.txt
elif [ "${ENVIRONMENT}" == "dev" ]; then
    echo -e "ENVIRONMENT: \e[32m${ENVIRONMENT} - $TARGETNAME\e[39m"
    echo "ENVIRONMENT: ${ENVIRONMENT} - $TARGETNAME" | tee /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.txt
else
    echo -e "Usage tot-package.sh \e[32mprod|dev\e[39m"
    exit;
fi
echo -e "Branch to package \e[32m${TARGETBRANCH}\e[39m"
echo "Branch to package ${TARGETBRANCH}" >> /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.txt
echo -e "Build \e[32m${TARGETBRANCH}\e[39m"
echo "Build ${BUILD}" >> /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.txt


cd /tmp/
rm -Rf /tmp/${TARGETNAME}
git clone ${GITPATH} --recurse-submodules ${TARGETNAME} -q
cd /tmp/${TARGETNAME}
git checkout ${TARGETBRANCH} -q
git submodule init
git submodule update

if [ -f "composer.json" ]; then
    echo "Exécutution de compsoer pour ${TARGETNAME}"
    echo "Exécutution de compsoer pour ${BUILD}" >> /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.txt
    rm -Rf vendor/composer/installed.json
    rm -Rf composer.lock
    find ./vendor -mindepth 1 ! -regex '^./vendor/totpsclasslib\(/.*\)?' -delete
    composer remove phpstan/phpstan phpunit/phpunit prestashop/php-dev-tools prestashop/header-stamp --no-progress --dev --no-install --no-update
    composer install --no-dev --optimize-autoloader --classmap-authoritative
fi

rm -Rf /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.zip
rm .git* -Rf

echo "Change name of version @version@ into ${TARGETVERSION} into ${TARGETNAME}.php file"
sed "s/@version@/${TARGETVERSION}/" /tmp/${TARGETNAME}/${TARGETNAME}.php > /tmp/${TARGETNAME}/${TARGETNAME}.php.tmp
mv /tmp/${TARGETNAME}/${TARGETNAME}.php.tmp /tmp/${TARGETNAME}/${TARGETNAME}.php
if [ -f "/tmp/${TARGETNAME}/config_dev.php" ] && [ "${ENVIRONMENT}" == "prod" ]; then
    echo -e "CONFIG FILE: \e[32mRemove config_dev.php\e[39m"
    rm /tmp/${TARGETNAME}/config_dev.php
    sed "s/config_dev\.php/config_prod.php/" /tmp/${TARGETNAME}/${TARGETNAME}.php > /tmp/${TARGETNAME}/${TARGETNAME}.php.tmp
    mv /tmp/${TARGETNAME}/${TARGETNAME}.php.tmp /tmp/${TARGETNAME}/${TARGETNAME}.php
elif [ -f "/tmp/${TARGETNAME}/config_prod.php" ] && [ "${ENVIRONMENT}" == "dev" ]; then
    echo -e "CONFIG FILE: \e[32mRemove config_prod.php\e[39m"
    sed "s/config_prod\.php/config_dev.php/" /tmp/${TARGETNAME}/${TARGETNAME}.php > /tmp/${TARGETNAME}/${TARGETNAME}.php.tmp
    mv /tmp/${TARGETNAME}/${TARGETNAME}.php.tmp /tmp/${TARGETNAME}/${TARGETNAME}.php
else
    echo -e "CONFIG FILE: \e[32mNo configuration files.\e[39m"
fi

if [ -f "package.json" ]; then
    export NVM_DIR="$HOME/.nvm" # set local path to NVM
    . ~/.nvm/nvm.sh             # add NVM into the Shell session
    nvm use 18  # choose current version
    echo "Install npm"
    npm install
    if [ "$?" -ne "0" ]; then
        echo "NPM failed!"
        exit 1
    fi
    npm run build
fi
if [ "$?" -ne "0" ]; then
    echo "Packaging failed!"
    exit 1
fi

rm -Rf 202
rm -Rf README.md
rm -Rf composer.*
rm -Rf cache.properties
rm -Rf node_modules
rm -Rf postcss.config.js
rm -Rf webpack.config.js
rm -Rf babel.config.js
rm .editorconfig .stylelintignore .stylelintignore browserlist docker-compose.yml
rm -Rf views/_dev
rm -Rf .php_cs.dist
rm -Rf package.json
rm -Rf package-lock.json
rm -Rf sonar-project.properties
rm -Rf composer.lock

cd /tmp/

zip -9 -r -q --exclude=\*.DS_Store\* --exclude=\*._.DS_Store\* --exclude=\*__MACOSX\* --exclude=\*.buildpath\*  --exclude=\*.dropbox\* --exclude=\*.git\* --exclude=\*.idea\* --exclude=\*.project\* --exclude=\*.sass-cache\* --exclude=\*.settings\* --exclude=\*.svn\* --exclude=\*config.codekit\* --exclude=\*desktop.ini\* --exclude=\*nbproject\* --exclude=\*.log --exclude=${TARGETNAME}/config.xml --exclude=${TARGETNAME}/config_\*.xml /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.zip ./${TARGETNAME}

php ${SCRIPTPATH}/autoindex.php /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.zip

echo -e "\n\e[1mZIP File \e[32m"/tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.zip"\e[39m created."
echo -e "\nZIP File "${ADDONPATH}/202/build/packages/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.zip" created." >> /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.txt

rm -Rf /tmp/${TARGETNAME}

mv /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.txt ${ADDONPATH}/202/build/packages
cp /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.zip ${ADDONPATH}/202/build/packages

cd /tmp/
unzip v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.zip
ls -la /tmp
cd /tmp/${TARGETNAME}
find . -type f -exec md5sum "{}" + > /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.md5
mv /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.md5 ${ADDONPATH}/202/build/packages
cd ../
mv v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.md5 ${ADDONPATH}/202/build/packages
rm -Rf /tmp/${TARGETNAME}
rm /tmp/v${TARGETVERSION}-${ENVIRONMENT}-${TARGETNAME}.zip
