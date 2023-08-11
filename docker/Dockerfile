#
FROM php:7.3-fpm-alpine
RUN set -ex \
    && apk --no-cache add \
    postgresql-dev \
    libzip \
    libzip-dev \
    libjpeg-turbo-dev \
    libpng-dev

#gd    
RUN docker-php-ext-install pdo pdo_mysql mysqli pdo_pgsql pgsql zip

RUN apk --update add freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    shadow \
    libzip-dev \
    gettext \
    gettext-dev \
    icu-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gettext intl exif \
    && docker-php-ext-configure gd --with-gd \
        --with-png-dir=/usr/include/ \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

    
WORKDIR /app
EXPOSE 9900
CMD ["php-fpm"]
