# 1. Use the official lightweight PHP Apache environment as our base runtime
FROM php:8.2-apache

# 2. Install essential system libraries and SQLite utilities
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_sqlite

# 3. Enable Apache rewrite engine module required by Laravel routing rules
RUN a2enmod rewrite

# 4. Point the Apache public serving root directory straight to Laravel's entry directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 5. Move your local school application source files inside the container working space
COPY . /var/www/html

# 6. Install Composer directly inside the image environment build space
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader

# 7. Grant the Apache system user absolute ownership permissions over files to avoid file blocks
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 8. Open up internal web network container traffic port
EXPOSE 80

# 9. Clear caches at runtime launch and start the Apache web engine server
CMD php artisan config:cache && php artisan route:cache && apache2-foreground
