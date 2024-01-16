FROM php:7.3.6-fpm

ENV TZ Asia/Jakarta
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 23F3D4EA75716059

# install Lib for composer
RUN apt-get update -qq && \
    apt-get install --no-install-recommends -y libpq-dev git zip unzip && \
    apt-get clean && \
    rm -rf /var/cache/apt

RUN docker-php-ext-install mbstring pdo pdo_pgsql

# php.conf php-fpm.conf
COPY docker/app/conf/php/php.ini /usr/local/etc/php/php.ini
COPY docker/app/conf/php/docker.conf /usr/local/etc/php-fpm.d/docker.conf

# install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash
RUN apt-get install --yes nodejs
RUN node -v
RUN npm -v
RUN npm i -g nodemon
RUN nodemon -v

COPY . /app

WORKDIR /app
RUN /usr/local/bin/composer install -d /app

# change owner
RUN chown www-data:www-data -R ./
