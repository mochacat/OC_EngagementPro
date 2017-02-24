FROM ubuntu:latest

RUN apt-get update

# Install system tools and libraries
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install curl vim \
  apache2 \
  php5 \
  libapache2-mod-php5 \ 
  php5-mysql \
  php5-gd \
  php5-curl \
  php5-mcrypt \
  && php5enmod mcrypt

# Set apache vars
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

RUN rm -rf /var/www/html
RUN mkdir /var/www/html
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Setup OpenCart file system

ENV OC_VER 2.0.3.1
ENV OC_FILE opencart.tar.gz
ENV OC_URL https://github.com/opencart/opencart/archive/${OC_VER}.tar.gz

WORKDIR /var/www/html

ADD ${OC_URL} ${OC_FILE} 
RUN tar xzf ${OC_FILE} --strip 2
RUN chown -R www-data:www-data .
RUN mv config-dist.php config.php 
RUN mv admin/config-dist.php admin/config.php
RUN chmod -R 777 image/ image/cache/ image/catalog/ 
RUN chmod 777 system/library/session.php config.php admin/config.php

# Dev mode

RUN echo "\n display_errors = 1; \n error_reporting = E_ALL;" >> php.ini

#Update user group permissions for extension w/ install

COPY user_group.sql user_group.sql
RUN cat user_group.sql  >> install/opencart.sql

COPY start.sh start.sh
RUN chmod 777 start.sh

# Expose ports for our webserver
EXPOSE 80 

CMD ["./start.sh"]
