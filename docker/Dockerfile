FROM php:8.1-apache

# Activar mod_rewrite
RUN a2enmod rewrite

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libonig-dev libpng-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath

# Definir DocumentRoot a public/
ENV APACHE_DOCUMENT_ROOT=/var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
