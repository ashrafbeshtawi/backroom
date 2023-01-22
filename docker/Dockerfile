FROM php:7.4-apache

# Install PostgreSQL client libraries
RUN apt-get update && \
    apt-get install -y libpq-dev

# Install PHP PostgreSQL extension
RUN docker-php-ext-install pgsql