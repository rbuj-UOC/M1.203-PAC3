FROM php:8-fpm-alpine

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && apk del -f .build-deps


COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
