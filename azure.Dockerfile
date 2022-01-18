FROM ubuntu:18.04

ARG DBUSER
ARG DBPASSWORD
ARG DBHOST

ENV DBUSER $DBUSER
ENV DBPASSWORD $DBPASSWORD
ENV DBHOST $DBHOST

ARG DEBIAN_FRONTEND=noninteractive

RUN apt update

RUN mkdir /run/php

RUN apt install --yes php
RUN apt install --yes php-fpm
RUN apt install --yes nginx
RUN apt install --yes doctrine
RUN apt install --yes php-curl
RUN apt install --yes php-gd
RUN apt install --yes php-dom
RUN apt install --yes php-xml

RUN apt install --yes supervisor

RUN service php7.2-fpm start

#ENV SERVER_NAME=localhost

# COPY ["src/bin", "/var/www/html/bin"]
# COPY ["src/config", "/var/www/html/config"]
# COPY ["src/data", "/var/www/html/data"]
# COPY ["src/public", "/var/www/html/public"]
# COPY ["src/src", "/var/www/html/src"]
# COPY ["src/vendor", "/var/www/html/vendor"]
# COPY ["src/web", "/var/www/html/web"]

# RUN mkdir /var/www/html/logs
# RUN touch /var/www/html/logs/error.log

# RUN chmod 777 /var/www/html/logs/error.log
# RUN chmod 007 /var/www/html/data/

# COPY ["config/nginx/default.fcgi.conf", "/etc/nginx/sites-available/default"]
# COPY ["config/supervisor/supervisord.conf", "/etc/supervisor/conf.d/supervisord.conf"]
# COPY ["config/php-fpm/php.ini", "/etc/php/7.2/fpm/php.ini"]

# CMD ["supervisord"]