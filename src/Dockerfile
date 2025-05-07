FROM php:8.1-apache

# Activar mod_rewrite
RUN a2enmod rewrite

# Instalar Node.js y dependencias
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

# Configurar Apache para Laravel
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Directorio de trabajo
WORKDIR /var/www/html

# Crear carpetas necesarias por si no se montan
RUN mkdir -p storage/framework/{cache/data,sessions,views} bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap

# Asegurar permisos
RUN chown -R www-data:www-data /var/www/html

USER www-data

CMD ["apache2-foreground"]
