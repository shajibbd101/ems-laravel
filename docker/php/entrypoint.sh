#!/bin/sh
set -e

echo "Running Docker entrypoint..."

# Wait for database to be ready
echo "Waiting for database..."
until php artisan db:seed --force 2>/dev/null; do
    echo "Database not ready, waiting..."
    sleep 2
done

echo "Database is ready!"

# Clear and cache config in production
if [ "${APP_ENV}" = "production" ]; then
    echo "Optimizing for production..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm