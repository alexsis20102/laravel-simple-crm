#!/bin/sh

echo "Fixing permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "Waiting for MySQL..."

until php -r "
try {
    new PDO('mysql:host=db;port=3306;dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');
    echo 'Database is ready';
} catch (Exception \$e) {
    exit(1);
}
"; do
  sleep 2
done

if [ ! -f /var/www/public_volume/index.php ]; then
  cp -r /var/www/public/* /var/www/public_volume/
fi

cd /var/www

if [ ! -f .env ]; then
  echo "Creating .env..."
  cp .env.example .env
fi


echo "Checking APP_KEY..."

if [ -z "$APP_KEY" ] || ! grep -q "^APP_KEY=base64" .env 2>/dev/null; then
  echo "Generating APP_KEY..."
  php artisan key:generate --force
else
  echo "APP_KEY already exists"
fi


echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force

echo "Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting php-fpm..."
exec php-fpm -F