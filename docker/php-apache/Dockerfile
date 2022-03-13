FROM php:7.2-apache

RUN apt-get update \
    && docker-php-ext-install pdo_mysql

COPY ./src/ /var/www/html/
