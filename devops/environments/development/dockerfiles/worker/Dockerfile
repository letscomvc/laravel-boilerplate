FROM ambientum/php:7.3

RUN sudo apk upgrade --update && sudo apk add \
         freetype-dev \
        libjpeg-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        g++ \
        make \
        bash \
        zlib-dev \
        wget \
        curl \
        libxrender \
        autoconf \
        automake \
        libtool \
        nasm

USER root

RUN echo '* * * * * cd /var/www/app && php artisan schedule:run' > /etc/crontabs/root

ENTRYPOINT crond && php artisan horizon
