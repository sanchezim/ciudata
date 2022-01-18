FROM php:8.1.1-fpm

ARG DEBIAN_FRONTEND=noninteractive

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    iputils-ping \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql pcntl

RUN docker-php-source extract \
    # do important things \
    && docker-php-source delete

# 
# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    nano \
    supervisor
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Agregar usuario para la aplicación laravel
# RUN groupadd -g 1000 www
# RUN useradd -u 1000 -ms /bin/bash -g www www

# Copiar el directorio existente a /var/www
COPY config/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY src /var/www


RUN chmod 777 /var/www/storage/
# RUN service supervisor start
# RUN php artisan jwt:secret --force
# RUN php artisan horizon
# RUN echo "alias mf=php artisan migrate:fresh "
# copiar los permisos del directorio de la aplicación
# RUN chown -R www-data:www-data /var/www

# cambiar el usuario actual por www
# USER www

# exponer el puerto 9000 e iniciar php-fpm server
# EXPOSE 9000
CMD ["supervisord"]
# supervisorctl 