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
COPY . .

COPY --from=composer:2.6.3 /usr/bin/composer /usr/bin/composer

RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction
RUN composer dump-autoload --optimize
RUN npm install
RUN npm update

EXPOSE 80

ENTRYPOINT [ "./docker-entrypoint.sh" ]
