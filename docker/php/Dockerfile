FROM php:8.0-fpm

ARG DEBIAN_FRONTEND=noninteractive

# Install Libs
RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-utils build-essential libpng-dev libjpeg62-turbo-dev libxml2-dev libmcrypt-dev \
    libgd3 libgd-dev libwebp-dev libpq-dev libmagickwand-dev libfreetype6-dev \
    libhiredis-dev libmemcached-dev pkg-config libcurl4-gnutls-dev zlib1g-dev libicu-dev libedit-dev \
    libncurses5-dev libtidy-dev libzip-dev nghttp2 msmtp msmtp-mta git curl zip openssl libonig-dev openssh-server ssh vim && \
    apt-get -y autoremove && apt-get -y clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Pear Extensions
RUN pecl channel-update pecl.php.net
RUN pecl install xdebug mcrypt memcached
RUN docker-php-ext-enable xdebug mcrypt memcached

# Install GD
RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# Install PHP Extensions not installed by default
RUN docker-php-ext-install mysqli pdo pdo_mysql zip bcmath intl tidy opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]
