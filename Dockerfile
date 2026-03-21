# =============================================
# Stage 1: Composer (for dependencies only)
# =============================================
FROM composer:2 AS composer

# =============================================
# Stage 2: PHP Application
# =============================================
FROM php:8.4-fpm-alpine AS php-app

# Install essential packages
RUN apk add --no-cache \
        zip \
        unzip \
        libzip-dev \
        oniguruma-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        autoconf \
        g++ \
        make \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath zip gd

# Copy composer from composer stage
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files
COPY composer.json composer.lock* ./

# Install production dependencies only (skip scripts for faster install)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Fix ownership
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Expose port
EXPOSE 9000

CMD ["php-fpm"]