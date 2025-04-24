FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    zip unzip \
    libmemcached-dev \
    zlib1g-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql
