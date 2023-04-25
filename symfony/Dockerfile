FROM php:8.2-apache
ARG COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /var/www/
RUN apt-get update && \
    apt-get install -y libicu-dev libpq-dev libzip-dev unzip git && \
    docker-php-ext-install intl pdo pdo_pgsql zip && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    a2enmod rewrite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . /var/www/
RUN composer install

