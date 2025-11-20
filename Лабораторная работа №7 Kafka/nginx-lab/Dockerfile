FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    git \
    unzip \
    wget \
    libzip-dev \
    && docker-php-ext-install zip

# Прямая загрузка Composer phar
RUN wget https://github.com/composer/composer/releases/latest/download/composer.phar -O /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

WORKDIR /var/www/html

COPY www/composer.* ./

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY www/ ./

RUN mkdir -p data && chmod 755 data