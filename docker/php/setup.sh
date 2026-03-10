#!/bin/bash

echo "setup.sh is started"

cd /var/www/html

mkdir -p vendor
composer install --optimize-autoloader --no-interaction --ignore-platform-reqs

echo "setup.sh completed"

# run infin fpm
php-fpm