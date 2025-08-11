FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    vim \
    nano \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Composer files
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-progress --no-suggest --optimize-autoloader && \
    composer clear-cache

# Install Node.js and NPM via package manager (already added via feature, but ensure npm is ready)
# Note: Node is handled by devcontainer feature, so just verify

# Copy init script
COPY .devcontainer/init.sh /var/www/html/.devcontainer/init.sh
# Set www-data as user
USER www-data

EXPOSE 8000
CMD ["php-fpm"]