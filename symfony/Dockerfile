FROM php:8.2-apache
ARG COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /var/www/
RUN apt-get update && \
    apt-get install -y libicu-dev libpq-dev libzip-dev unzip git && \
    docker-php-ext-install intl pdo pdo_pgsql zip && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    a2enmod rewrite
### install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
### copy project
COPY . /var/www/
###install dependencies
RUN composer install

### jwt
RUN     set -e &&\
        apt-get install openssl &&\
        apt-get install acl &&\
        bin/console lexik:jwt:generate-keypair --overwrite &&\
        setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt &&\
        setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
