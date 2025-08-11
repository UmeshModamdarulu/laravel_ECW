# Use the official Dev Containers PHP image with Apache, PHP 8.2, and Debian Bookworm.
# This image already includes Composer, PHP-FPM, and Apache setup.
FROM mcr.microsoft.com/devcontainers/php:1-8.2-bookworm

# Install additional PHP extensions required by Laravel and for Redis.
# `mysqli`, `pdo`, `pdo_mysql` are usually enabled or easily enabled by this base image.
# We explicitly install the `redis` extension.
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y \
        git-lfs \
        libzip-dev \
        unzip \
    && docker-php-ext-install pdo_mysql zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# [Optional] Uncomment this section to install additional OS packages if needed.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1

# Set the working directory (already set by devcontainers/php, but good for clarity)
WORKDIR /var/www/html
