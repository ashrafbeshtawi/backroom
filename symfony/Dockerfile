FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y libicu-dev libpq-dev libzip-dev unzip git && \
    docker-php-ext-install intl pdo pdo_pgsql zip && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    a2enmod rewrite


