FROM php:8.0-apache
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
COPY ./program /var/www/html
EXPOSE 80
