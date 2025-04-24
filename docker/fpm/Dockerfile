FROM php:8.2-fpm

RUN apt-get update && apt-get install zip unzip
RUN docker-php-ext-install mysqli pdo pdo_mysql

CMD ["php-fpm"]