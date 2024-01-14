FROM php:8.2.4-apache

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxml2-dev \
        libssl-dev \
        libbz2-dev \
        libzip-dev \
        zip \
    && rm -rf /var/lib/apt/lists/* 

RUN docker-php-ext-install pdo pdo_mysql soap sockets zip

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2.6.3 /usr/bin/composer /usr/bin/composer

COPY ./composer.* ./

RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

COPY . .

RUN composer dump-autoload --optimize