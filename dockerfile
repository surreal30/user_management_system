FROM php:8.0-apache
RUN a2enmod rewrite
WORKDIR /var/www/html
COPY ./program /var/www/html
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
EXPOSE 80
