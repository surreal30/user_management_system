FROM php:8.0-apache
RUN a2enmod rewrite
WORKDIR /app/public
ENV APACHE_DOCUMENT_ROOT /app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
COPY . /app
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
EXPOSE 80
