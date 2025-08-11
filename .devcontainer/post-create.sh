#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

echo "--- Starting post-create setup script ---"

# Define the workspace directory
WORKSPACE_DIR="/workspaces/${localWorkspaceFolderBasename}"

# Ensure we are in the workspace directory
cd "$WORKSPACE_DIR"

# 1. Symlink Laravel's public directory to Apache's default web root
echo "1. Linking Laravel's public directory to Apache's web root..."
# Remove existing /var/www/html if it's a directory (not a symlink)
if [ -d /var/www/html ] && ! [ -L /var/www/html ]; then
    sudo rm -rf /var/www/html
fi
# Create the symlink
sudo ln -s "$WORKSPACE_DIR/public" /var/www/html
echo "Symlink created: /var/www/html -> $WORKSPACE_DIR/public"

# 2. Set appropriate permissions for the workspace folder
echo "2. Setting permissions for workspace..."
sudo chown -R vscode:vscode "$WORKSPACE_DIR"
sudo chmod -R 775 "$WORKSPACE_DIR"
# Also ensure Apache can write to storage and bootstrap/cache
sudo chown -R www-data:www-data "$WORKSPACE_DIR/storage" "$WORKSPACE_DIR/bootstrap/cache"
sudo chmod -R 775 "$WORKSPACE_DIR/storage" "$WORKSPACE_DIR/bootstrap/cache"


# 3. Install Composer dependencies
echo "3. Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 4. Install NPM dependencies
echo "4. Installing NPM dependencies..."
npm install

# 5. Build front-end assets
# Adjust 'npm run dev' to 'npm run build' if you prefer a production build,
# or add checks for Laravel Mix/Vite config.
echo "5. Building front-end assets (npm run dev)..."
npm run dev || echo "NPM dev script failed or not found, continuing..." # Use 'true' to always succeed if 'npm run dev' is optional

# 6. Generate Laravel application key if not present
if [ ! -f .env ]; then
    echo "6. Creating .env file from .env.example..."
    cp .env.example .env
fi
if [ "$(grep -q "^APP_KEY=$" .env; echo $?)" -eq 0 ]; then
    echo "6. Generating Laravel application key..."
    php artisan key:generate
fi

# 7. Run database migrations and seeders (optional - uncomment if you want this automated)
# echo "7. Running database migrations..."
# php artisan migrate --force
# echo "7. Running database seeders..."
# php artisan db:seed --force

# 8. Link storage (essential for Laravel)
echo "8. Linking storage..."
php artisan storage:link

# 9. Cache Laravel configurations
echo "9. Caching Laravel configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Dev container setup complete! You can now access your Laravel app and services. ---"
