FROM php:8.0-cli-alpine

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apk add build-base php8-dev && \
    pecl -q install mongodb xdebug && \
    docker-php-ext-enable mongodb xdebug && \
    curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
