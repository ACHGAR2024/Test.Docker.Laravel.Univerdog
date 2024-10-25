# Utiliser l'image officielle PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    git \
    curl \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl gd \
    && rm -r /var/lib/apt/lists/*  # Nettoyer les fichiers temporaires

# Activer le module Apache mod_rewrite
RUN a2enmod rewrite

# Copier les fichiers de l'application
COPY . /var/www/html

# Définir les permissions des fichiers
RUN chown -R www-data:www-data /var/www/html

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
