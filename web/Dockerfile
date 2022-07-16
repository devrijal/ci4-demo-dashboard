FROM php:8.1.8-fpm-alpine3.16
LABEL maintainer='icalboardgold@gmail.com'

COPY . /var/www

WORKDIR /var/www

RUN apk -U upgrade --no-cache && \
    apk add zip curl icu-dev && \
    docker-php-ext-install intl pdo_mysql mysqli && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && composer install
EXPOSE 9000
CMD ["php-fpm"]