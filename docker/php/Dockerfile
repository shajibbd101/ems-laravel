FROM php:8.4-fpm-alpine

RUN apk add --no-cache zip unzip git curl oniguruma-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www