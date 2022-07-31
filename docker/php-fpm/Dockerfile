FROM php:8.1-fpm

RUN  apt-get upgrade && apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip && docker-php-ext-install intl opcache pdo pdo_mysql && docker-php-ext-configure zip && docker-php-ext-install zip
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get install -y --no-install-recommends \
             libfreetype6-dev \
             libjpeg62-turbo-dev \
             libpng-dev \
         && docker-php-ext-configure gd  && docker-php-ext-install -j$(nproc) gd

WORKDIR /var/www
ADD ./php.ini /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN git config --global user.email "bayn151@gmail.com" && git config --global user.name "Yan"


