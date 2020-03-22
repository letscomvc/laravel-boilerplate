FROM jguyomard/laravel-php

LABEL maintainer="danilopinotti@lets.com.vc"

RUN apk upgrade --update && apk add \
    curl \
    nano \
    bash \
    shadow \
    libtool \
    zlib-dev \
    exiftool \
    libpng-dev \
  && docker-php-ext-install gd \
  && docker-php-ext-install exif \
  && docker-php-ext-install opcache

RUN echo '* * * * * cd /var/www/app && php artisan schedule:run' > /etc/crontabs/root

WORKDIR /var/www/app

ENTRYPOINT crond && php artisan horizon
