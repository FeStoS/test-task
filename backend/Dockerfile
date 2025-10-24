FROM php:8.3-fpm-alpine

RUN apk add --no-cache git curl zip unzip icu-dev oniguruma-dev libzip-dev \
    && docker-php-ext-install pdo_mysql intl mbstring zip bcmath

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
EXPOSE 9000
CMD ["php-fpm"]
