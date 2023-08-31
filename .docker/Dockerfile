FROM php:7.3-apache

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /srv/app

RUN docker-php-ext-install mbstring pdo pdo_mysql \
    && chown -R www-data:www-data /srv/app \
    && a2enmod rewrite


# "xdebug-2.9.0" for PHP<=7.4 — "xdebug" (3) for PHP>=8
#ARG XDEBUG_VERSION="xdebug-2.9.0"



#RUN a2enmod rewrite

#RUN docker-php-ext-install pdo pdo_mysql

#RUN yes | pecl install ${XDEBUG_VERSION} \
   # && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
  #  && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
  #  && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini



