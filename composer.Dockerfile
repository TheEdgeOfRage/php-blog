FROM composer

WORKDIR /var/www/html
COPY ./src/composer.json ./src/composer.lock ./
