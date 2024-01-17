# PHP
FROM php:8.2.4-apache
ENV COMPOSER_ALLOW_SUPERUSER=1

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
        gnupg2 \
        curl

RUN docker-php-ext-install pdo pdo_mysql soap sockets zip bcmath

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get update && apt-get install -y nodejs 

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY --from=composer:2.6.3 /usr/bin/composer /usr/bin/composer

COPY ./composer.* ./
COPY ./package.json ./
COPY ./package-lock.json ./
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction
RUN npm install
RUN npm update

COPY . .

RUN composer dump-autoload --optimize

EXPOSE 80

ENTRYPOINT [ "./docker-entrypoint.sh" ]
