FROM php:8.1-apache

RUN a2enmod rewrite

# Instalar Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

RUN apt-get update
RUN apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev

RUN docker-php-ext-install \
    mysqli \
    gd \
    zip \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY ./src/ /var/www/html

# Configurar Apache
COPY ./docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/html

# Instalar dependencias de Composer y npm, y ejecutar build
RUN chown -R www-data:www-data . \
    && composer install \
    && npm install \
    && npm run build

# Asignar permisos correctos a storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache

# Solucionar problema de permisos en /var/run/
RUN chmod -R 777 /var/run/

USER www-data

# Iniciar Apache correctamente
CMD exec apache2-foreground
