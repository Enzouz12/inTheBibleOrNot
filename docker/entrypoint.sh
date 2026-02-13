#!/bin/bash
set -e

# Initialize database on persistent volume if it doesn't exist yet
if [ ! -f /data/database.sqlite ]; then
    if [ -f /var/www/html/database/database.sqlite ]; then
        cp /var/www/html/database/database.sqlite /data/database.sqlite
        echo "Database copied to persistent volume."
    else
        touch /data/database.sqlite
        echo "Empty database created on persistent volume."
    fi
fi

chown www-data:www-data /data/database.sqlite

# Laravel optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
