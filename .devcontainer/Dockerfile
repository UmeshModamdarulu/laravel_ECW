FROM php:8.2-fpm

# Install system dependencies
RUN groupadd -g 1000 vscode && useradd -m -u 1000 -g vscode vscode
RUN chown -R vscode:vscode /var/www/html

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

# Copy composer files only if they exist
# This avoids COPY errors during initial build
COPY ./composer.json ./composer.lock* ./

# Install PHP dependencies (as root to avoid permission errors)
RUN composer install --no-dev --no-scripts --no-progress --no-suggest --optimize-autoloader || true \
    && composer clear-cache || true

# Copy init script
COPY .devcontainer/init.sh .devcontainer/init.sh

# Change ownership to www-data
RUN chown -R www-data:www-data /var/www/html

# Switch to www-data user for security
USER www-data

EXPOSE 8000
CMD ["php-fpm"]
