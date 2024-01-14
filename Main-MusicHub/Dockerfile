# PHP
FROM php:8.2.4-apache as php

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxml2-dev \
        libssl-dev \
        libbz2-dev \
        libzip-dev \
        libpq-dev \
        libcurl4-gnutls-dev \
        zip \
        unzip \
    && rm -rf /var/lib/apt/lists/* 

RUN docker-php-ext-install pdo pdo_mysql soap sockets zip bcmath

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www
COPY . .

COPY --from=composer:2.6.3 /usr/bin/composer /usr/bin/composer
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

RUN composer dump-autoload --optimize

EXPOSE 80

ENTRYPOINT [ "./docker-entrypoint.sh" ]

# Node
FROM node:latest as node
WORKDIR /var/www
COPY . .

RUN npm install
