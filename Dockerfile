# ---- Composer dependencies ----
FROM composer:latest AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize --no-dev

# ---- Frontend assets ----
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources/ resources/
COPY --from=vendor /app/vendor/laravel/framework/src/Illuminate/Pagination/resources/ vendor/laravel/framework/src/Illuminate/Pagination/resources/
RUN mkdir -p storage/framework/views
RUN npm run build

# ---- Production image ----
FROM php:8.4-apache

RUN apt-get update && apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf \
    && a2enmod rewrite

WORKDIR /var/www/html

COPY --from=vendor /app/ .
COPY --from=assets /app/public/build/ public/build/

RUN mkdir -p storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
