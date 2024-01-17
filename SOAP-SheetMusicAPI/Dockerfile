FROM php:8.2.4-apache
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev libxml2-dev \
        libssl-dev libbz2-dev libzip-dev zip \
        gnupg2 curl libasound2 libatk-bridge2.0-0 \
        libatk1.0-0 libatspi2.0-0 libc6 libcairo2 \
        libcups2 libdbus-1-3 libdrm2 libexpat1 \
        libgbm1 libgcc1 libglib2.0-0 libnspr4 \
        libnss3 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 \
        libuuid1 libx11-6 libx11-xcb1 libxcb-dri3-0 \
        libxcb1 libxcomposite1 libxcursor1 libxdamage1 \
        libxext6 libxfixes3 libxi6 libxkbcommon0 libgtk-3-0\
        libxrandr2 libxrender1 libxshmfence1 libxss1 libxtst6 

ENV LD_LIBRARY_PATH="/usr/lib/x86_64-linux-gnu:${LD_LIBRARY_PATH}"

RUN docker-php-ext-install pdo pdo_mysql soap sockets zip

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get update && apt-get install -y nodejs 

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=composer:2.6.3 /usr/bin/composer /usr/bin/composer

COPY ./composer.* ./
COPY ./package.json ./
COPY ./package-lock.json ./
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction
RUN npm install
RUN npm update

COPY . .

RUN composer dump-autoload --optimize

RUN mkdir pdfs
RUN chmod -R 755 /var/www/html/pdfs && \
    chown -R www-data:www-data /var/www/html/pdfs
