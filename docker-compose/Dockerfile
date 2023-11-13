FROM php:apache

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_mysql

RUN a2enmod rewrite
RUN service apache2 restart