FROM composer:2

RUN apk add --no-cache icu-dev nodejs npm \
    && docker-php-ext-install intl pdo_mysql
