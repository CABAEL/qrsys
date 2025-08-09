FROM php:7.4-fpm

# Install system dependencies, PHP extensions, and Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    libcurl4-openssl-dev \
    openssl \
    supervisor \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd curl xml

# Copy composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application code
COPY . .

# Clear composer cache and install dependencies
RUN composer clear-cache && composer install --no-dev --optimize-autoloader

# Laravel package discovery
RUN php artisan package:discover --ansi

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy custom Nginx config
COPY ./docker/nginx.conf /etc/nginx/sites-available/default

# Copy supervisor config
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

# Start supervisor which will manage php-fpm and nginx
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
