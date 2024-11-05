# Dockerfile
# Usar la imagen oficial de PHP con extensiones necesarias para Laravel
FROM php:8.2-fpm

# Instalar extensiones y dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorio de la aplicación
WORKDIR /var/www

# Copiar todos los archivos
COPY . .

RUN rm -rf node_modules package-lock.json

# Instalar dependencias de PHP y JavaScript
RUN composer install && npm install && npm run build

# Cambiar permisos de las carpetas de almacenamiento y caché
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto
EXPOSE 9000

CMD ["php-fpm"]