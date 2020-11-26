FROM jguyomard/laravel-php

LABEL maintainer="danilopinotti@hotmail.com"

ARG UNAME=app
ARG UID=1000
ARG GID=1000

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

RUN apk upgrade --update && apk add \
    g++\
    make\
    nodejs \
    nodejs-npm

RUN composer self-update --stable

RUN groupadd -g $GID -o $UNAME \
    && useradd -m -u $UID -g $GID -o -s /bin/bash $UNAME

USER $UNAME

WORKDIR /var/www/app
