FROM composer as build

COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock

RUN composer install

FROM php:7.4-apache-buster

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions mysqli pdo_mysql

COPY --from=build /app/vendor /var/www/html/vendor

COPY assets /var/www/html/assets
COPY config /var/www/html/config
COPY src /var/www/html/src
COPY .htaccess /var/www/html/
COPY index.php /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite