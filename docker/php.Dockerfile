FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    libpq-dev \
    libzip-dev \
    openssl \
    curl \
    git vim unzip cron \
    zip \
    libjpeg-turbo-progs \
    libpng-dev \
    --no-install-recommends \
    && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    gd \
    pdo_mysql \
    tokenizer

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) \
    bcmath \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    tokenizer \
    zip

# Install PHP Xdebug 2.9.8
RUN pecl install -o xdebug-2.9.8

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g n \
    && n stable

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

ADD ./docker/docker-php.ini $PHP_INI_DIR/conf.d/
ADD ./docker/docker-php-xdebug.ini $PHP_INI_DIR/conf.d/zz-xdebug-settings.ini

ADD ./docker/php.docker-entroypoint.sh /usr/local/bin/

RUN ["chmod", "+x", "/usr/local/bin/php.docker-entroypoint.sh"]

ENTRYPOINT [ "/usr/local/bin/php.docker-entroypoint.sh" ]

CMD ["php-fpm"]
