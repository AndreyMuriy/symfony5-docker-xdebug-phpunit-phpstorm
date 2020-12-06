FROM php:7.3-fpm

RUN echo " --->> Install packages" \
    && apt-get clean && apt-get update \
    && apt-get install -y --no-install-recommends \
        libpq-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        unzip \
        wget \
        git \
    && rm -rf /var/lib/apt/lists/*

RUN echo " --->> Install extensions" \
    && docker-php-ext-install intl soap pcntl pdo pdo_pgsql zip \
    && pecl install xdebug-2.9.8 \
    && pecl install pcov-1.0.6 \
    && docker-php-ext-enable xdebug pcov

RUN echo " --->> Install Symfony CLI" \
    && wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN echo " --->> Install composer" \
    && set -ex \
    && cd /tmp \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer --version=1.10.17 \
    && chmod +x /usr/bin/composer \
    && rm -rf /tmp/*

COPY ./services/php-fpm/php.ini /usr/local/etc/php/php.ini
EXPOSE 9000

WORKDIR /var/www
