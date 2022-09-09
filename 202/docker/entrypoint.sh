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

set -e
set -x

if [ "${RUN_USER}" != "www-data" ]; then 
useradd -m $RUN_USER; 
echo "export APACHE_RUN_USER=$RUN_USER \
export APACHE_RUN_GROUP=$RUN_USER" >> /etc/apache2/envvars 
fi

/etc/init.d/mariadb start

if [ "$PS_DOMAIN" ]; then 
    mysql -h localhost -u root prestashop -e "UPDATE ps_shop_url SET domain='$PS_DOMAIN', domain_ssl='$PS_DOMAIN'" 
fi

cd  /var/www/html/modules/axeptiocookies

composer update

php /var/www/html/bin/console prestashop:module install axeptiocookies -e prod

chown $RUN_USER:$RUN_USER /var/www/html -Rf

exec apache2-foreground