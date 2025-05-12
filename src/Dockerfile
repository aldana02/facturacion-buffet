FROM php:8.1-apache

# Activar mod_rewrite
RUN a2enmod rewrite

# Instalar dependencias del sistema y Node.js
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    npm && \
    curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

# Instalar extensiones de PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    gd \
    mbstring \
    exif \
    pcntl \
    bcmath

# Instalar Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Cambiar DocumentRoot a /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copiar el código
COPY . /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias PHP y JS
RUN composer install \
    && npm install \
    && npm run build

# Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# Exponer el puerto (Apache ya usa 80 por defecto)
EXPOSE 80

CMD ["apache2-foreground"]

