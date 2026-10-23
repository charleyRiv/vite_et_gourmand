FROM php:8.4-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    curl \
    libssl-dev \
    pkg-config \
    && apt-get clean

# Extensions PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip

# Extension MongoDB via PECL - version spécifique
RUN pecl install mongodb-2.4.0 \
    && docker-php-ext-enable mongodb

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copie les fichiers composer
COPY composer.json composer.lock ./

# Installe les dépendances
RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction

EXPOSE 9000