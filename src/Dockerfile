FROM php:8.1-apache

# Activar mod_rewrite
RUN a2enmod rewrite

# Instalar Node.js y dependencias del sistema
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get update \
 && apt-get install -y \
    nodejs \
    zip \
    unzip \
    git \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    libicu-dev \
 && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorios necesarios para Laravel
WORKDIR /var/www/html
RUN mkdir -p storage/framework/{cache/data,sessions,views} bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html

USER www-data

CMD ["apache2-foreground"]