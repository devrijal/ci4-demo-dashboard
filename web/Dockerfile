FROM php:8.1.8-fpm-alpine3.16
LABEL maintainer='icalboardgold@gmail.com'

COPY . /var/www

WORKDIR /var/www

RUN apk -U upgrade --no-cache && \
    apk add zip curl icu-dev && \
    docker-php-ext-install intl pdo_mysql mysqli
EXPOSE 9000
CMD ["php-fpm"]