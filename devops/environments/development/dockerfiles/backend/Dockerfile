FROM ambientum/php:7.2-nginx
LABEL maintainer="danilopinotti@lets.com.vc"
RUN sudo apk upgrade --update && sudo apk add --update \
     libpng-dev bash

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
        nasm \
        nodejs \
        nodejs-npm

RUN sudo wget https://github.com/madnight/docker-alpine-wkhtmltopdf/raw/master/wkhtmltopdf -P /usr/local/bin && \
      sudo chmod +x /usr/local/bin/wkhtmltopdf

RUN sudo sed -i -e 's/^memory_limit = .*$/memory_limit = 512M/g' /etc/php7/php.ini;

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php
