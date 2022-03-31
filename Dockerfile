FROM composer as build

COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock

RUN composer install

FROM php:7.4-apache-buster

COPY --from=build /app/vendor /var/www/html/vendor

COPY assets /var/www/html/assets
COPY config /var/www/html/config
COPY src /var/www/html/src
COPY .htaccess /var/www/html/
COPY index.php /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite

EXPOSE 80