
FROM composer:2 AS composer
WORKDIR /app
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --ignore-platform-reqs --no-scripts --no-autoloader

FROM php:8.2-apache
WORKDIR /var/www/html


COPY --from=composer /app/vendor/ /var/www/html/vendor/


RUN apt-get update && \
    apt-get install -y \
        libssl-dev \
        libsasl2-dev \
    && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install mongodb-1.11.0 && docker-php-ext-enable mongodb


COPY . .


CMD ["apache2-foreground"]