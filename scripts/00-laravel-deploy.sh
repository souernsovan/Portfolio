#!/usr/bin/env bash
set -e

echo "Running composer"
composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

echo "Linking storage..."
php artisan storage:link || true

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running Seed..."
php artisan db:seed --force

echo "Clearing cache..."
php artisan cache:clear

echo "Clearing view cache..."
php artisan view:clear

echo "Clearing compiled classes..."
php artisan clear-compiled

echo "Deploy complete!"