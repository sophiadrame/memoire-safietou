#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --optimize-autoloader --ignore-platform-reqs --working-dir=/var/www/html
echo "generating cache"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
echo "Running migrations"
php artisan migrate --force