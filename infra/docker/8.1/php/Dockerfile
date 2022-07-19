FROM php:8.1-fpm-bullseye
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install git libicu-dev libonig-dev libzip-dev unzip locales && \
  # install gd library (with jpeg, and webp)
  apt-get install -y zlib1g-dev libpng-dev libjpeg62-turbo-dev libwebp-dev && \
  docker-php-ext-configure gd --with-jpeg --with-webp && \
  docker-php-ext-install -j$(nproc) gd && \
  # clean
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  locale-gen en_US.UTF-8 && \
  localedef -f UTF-8 -i en_US en_US.UTF-8 && \
  mkdir /var/run/php-fpm && \
  docker-php-ext-install intl pdo_mysql zip bcmath && \
  composer config -g process-timeout 3600 && \
  composer config -g repos.packagist composer https://packagist.org

COPY ./infra/docker/8.1/php/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./infra/docker/8.1/php/php.ini /usr/local/etc/php/php.ini
COPY ./infra/docker/8.1/php/start-container /work/start-container/
COPY ./src/ /work/backend/

WORKDIR /work/backend

RUN mkdir -p storage/framework/cache/data && \
    mkdir -p storage/framework/app/cache && \
    mkdir -p storage/framework/sessions && \
    mkdir -p storage/framework/views && \
    mkdir -p storage/logs && \
    mkdir -p bootstrap/cache && \
    chmod -R 777 storage && \
    chown -R www-data:www-data /work/backend && \
    chmod +x /work/start-container/start-container && \
    mkdir -p /home/www-data && \
    usermod -d /home/www-data www-data && \
    chown -R www-data:www-data /home/www-data && \
    chown -R www-data:www-data /composer/ && \
    composer install

# install xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

EXPOSE 9000
