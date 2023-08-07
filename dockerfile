FROM php:8.2
RUN docker-php-ext-install mysqli
COPY index.php .
COPY login.php .
COPY logout.php .
COPY add_user.php .
COPY list_user.php .
COPY check_login.php .
EXPOSE 2000
CMD ["php", "-S", "0.0.0.0:2000"] 
