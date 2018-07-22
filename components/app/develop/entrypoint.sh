#!/usr/bin/env sh
set -e

if [[ -f composer.json ]]; then
    echo "Installing dependencies"
    composer install
fi

echo "Removing config cache"
php artisan config:cache

echo "Removing config cache"
php artisan migrate

echo "Chmoding cache and storage folders"
chmod -R 777 /var/www/bootstrap/cache /var/www/storage

echo "Running PHP FPM"
php-fpm -D | tail -f $LOG_STREAM
