FROM php:fpm-bullseye

RUN docker-php-ext-install mysqli
COPY ./src/ ./
