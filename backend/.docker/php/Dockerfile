FROM php:7.4-fpm-alpine3.16 AS php

COPY --from=mlocati/php-extension-installer:1.5 /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer:2.5 /usr/bin/composer /usr/local/bin/composer

RUN install-php-extensions \
  pdo_mysql \
  intl \
  zip \
  opcache

COPY .docker/php/php.ini $PHP_INI_DIR/conf.d/
COPY .docker/php/php.ini $PHP_INI_DIR/conf.d/cli/conf.d/
COPY .docker/php/php.pool.conf /usr/local/etc/php-fpm.d/

RUN docker-php-source delete

WORKDIR /application
CMD php-fpm -F

FROM php as php_dev

RUN install-php-extensions xdebug
COPY .docker/php/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

FROM php as php_prod

COPY . /application
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-interaction --no-dev

RUN mkdir /application/var
RUN chown -R www-data:www-data /application
RUN chmod -R 777 /application/var
