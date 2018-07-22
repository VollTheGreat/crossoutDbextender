FROM php:7.1.18-fpm-alpine

WORKDIR /var/www

COPY ./develop/php.ini /usr/local/etc/php/
COPY ./develop/xdebug.ini /usr/local/etc/php/conf.d/
COPY ./develop/entrypoint-test.sh /usr/local/bin/

#RUN set -ex \
#    && apk add --no-cache freetype git libjpeg-turbo libpng unzip zip zlib-dev imagemagick-dev libzip \
#    && apk add --no-cache --virtual build-deps alpine-sdk autoconf freetype-dev libpng-dev libjpeg-turbo-dev libtool libzip-dev \
#    && docker-php-ext-configure zip --with-libzip \
#    && docker-php-ext-install bcmath pdo_mysql zip \
#    && pecl install imagick rar xdebug \
#    && docker-php-ext-enable imagick rar xdebug \
#    && printf "xdebug.remote_host=${XDEBUG_PORT}\n" | tee -a /usr/local/etc/php/conf.d/xdebug.ini

RUN set -ex \
    && apk add --no-cache freetype libpng zlib-dev \
    && apk add --no-cache --virtual build-deps alpine-sdk autoconf freetype-dev libpng-dev libjpeg-turbo-dev libtool libzip-dev \
    && docker-php-ext-install pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && printf "xdebug.remote_host=${XDEBUG_PORT}\n" | tee -a /usr/local/etc/php/conf.d/xdebug.ini

CMD entrypoint-test.sh