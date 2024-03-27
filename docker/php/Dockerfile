FROM php:8.2-apache
COPY php.ini /usr/local/etc/php/
RUN chmod 644 /usr/local/etc/php/php.ini

# Apacheモジュール有効化
RUN a2enmod deflate expires rewrite

RUN apt-get update \
  && apt-get install -y zlib1g-dev vim libzip-dev git \
  # mailcatcher用
    ruby ruby-dev rubygems libsqlite3-dev \
  && docker-php-ext-install zip pdo_mysql mysqli \
  && apt-get clean

# Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
# mailcatcher install
RUN gem install mailcatcher

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin
WORKDIR /var/www/html