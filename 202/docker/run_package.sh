#!/bin/bash
echo "Removing container axeptiocookies-ps-56 with image prestashop/prestashop:1.7.6.9-5.6"
docker rm -f axeptiocookies-ps-56
echo "Running container axeptiocookies-ps-56 with image prestashop/prestashop:1.7.6.9-5.6"
docker run -tid --rm -v ps-volume-axeptiocookies-ps-56:/var/www/html --name axeptiocookies-ps-56 prestashop/prestashop:1.7.6.9-5.6
echo "Exec remove module directory axeptiocookies in container"
docker exec -t axeptiocookies-ps-56 rm -rf /var/www/html/modules/axeptiocookies
docker cp $PWD/../../ axeptiocookies-ps-56:/var/www/html/modules/axeptiocookies
echo "Run packaging Inside Container in /var/www/html/modules/axeptiocookies"
docker exec -t axeptiocookies-ps-56 bash -c /var/www/html/modules/axeptiocookies/202/docker/package.sh
docker cp axeptiocookies-ps-56:/var/www/html/packages $PWD
