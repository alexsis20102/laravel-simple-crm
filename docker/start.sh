#!/bin/sh

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

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=8000