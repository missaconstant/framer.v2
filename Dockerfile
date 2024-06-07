FROM php:8.2-apache

# Installation des dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-enable pdo_mysql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Copier le code source de l'application
COPY . /var/www/html

# Répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances avec Composer
RUN composer install

# Définir le propriétaire des fichiers et les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exposer le port
EXPOSE 80

CMD ["apache2-foreground"]
