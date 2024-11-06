# Usamos una imagen base oficial de PHP
FROM php:8.2-apache

# Habilitar mod_rewrite (puede ser necesario para las rutas amigables de PHP)
RUN a2enmod rewrite

# Instalar dependencias necesarias para Composer y PHPUnit
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar PHPUnit globalmente usando Composer
RUN curl -sS https://phar.phpunit.de/phpunit.phar -o /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/phpunit

# Configuración del directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto al contenedor
COPY . /var/www/html

# Ejecutar composer install para instalar las dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Copiar el archivo de configuración Apache (puede variar según tu configuración)
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilitar el sitio y reiniciar Apache
RUN a2ensite 000-default.conf \
    && service apache2 restart

# Creación de la base de datos
COPY create-database.sql /docker-entrypoint-initdb.d/

# Exponer el puerto 80
EXPOSE 80

# Comando por defecto para iniciar el contenedor
CMD ["apache2-foreground"]
