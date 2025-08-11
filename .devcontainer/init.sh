#!/bin/bash
set -e

echo "🚀 Initializing Laravel Dev Environment..."

# Go to project root
cd /var/www/html

# Generate or copy .env if not exists
if [ ! -f .env ]; then
    echo "📄 Creating .env from .env.example"
    cp .env.example .env
fi

# Detect GitHub Codespace domain
export CODESPACE_NAME=$(echo $CODESPACE_NAME)
export GITHUB_CODESPACE_PORT_FORWARDING_DOMAIN=$(echo $GITHUB_CODESPACE_PORT_FORWARDING_DOMAIN)

if [ -n "$CODESPACE_NAME" ] && [ -n "$GITHUB_CODESPACE_PORT_FORWARDING_DOMAIN" ]; then
    APP_URL="https://${CODESPACE_NAME}-8000.${GITHUB_CODESPACE_PORT_FORWARDING_DOMAIN}"
    echo "🌐 Detected Codespace URL: $APP_URL"
    
    # Update .env
    sed -i "s|APP_URL=http://localhost:8000|APP_URL=${APP_URL}|g" .env
    sed -i "s|DB_HOST=127.0.0.1|DB_HOST=mysql|g" .env
    sed -i "s|DB_PORT=3306|DB_PORT=3306|g" .env
    sed -i "s|DB_DATABASE=laravel|DB_DATABASE=laravel|g" .env
    sed -i "s|DB_USERNAME=root|DB_USERNAME=laraveluser|g" .env
    sed -i "s|DB_PASSWORD=|DB_PASSWORD=secret|g" .env
    sed -i "s|REDIS_HOST=127.0.0.1|REDIS_HOST=redis|g" .env
    sed -i "s|MAIL_HOST=smtp.mailtrap.io|MAIL_HOST=mailhog|g" .env
    sed -i "s|MAIL_PORT=2525|MAIL_PORT=1025|g" .env
fi

# Generate key if not already done
if ! grep -q "APP_KEY=.*" .env; then
    echo "🔑 Generating Laravel app key..."
    php artisan key:generate --no-interaction
fi

# Install frontend dependencies
if [ -f "package.json" ]; then
    echo "📦 Installing Node.js dependencies..."
    npm ci --silent
    echo "🛠️  Building assets..."
    npm run build --silent
fi

# Ensure storage is linked
php artisan storage:link

echo "✅ Initialization complete!"