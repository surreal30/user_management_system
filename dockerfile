FROM php:8.0-apache
WORKDIR /var/www/html
COPY ./program /var/www/html
COPY ./program/traptest.sh /var/www/html
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN chmod +x traptest.sh
RUN /var/www/html/traptest.sh
EXPOSE 80
