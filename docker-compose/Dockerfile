FROM php:apache

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_mysql

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN a2enmod rewrite
RUN service apache2 restart