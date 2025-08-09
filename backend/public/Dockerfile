FROM php:7.4-fpm

WORKDIR /var/www/html

# Install system dependencies and PHP extensions commonly needed by Laravel and composer packages
RUN apt-get update && apt-get install -y \
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
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd curl xml

# Copy composer binary from official composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Clear composer cache (optional but good practice)
RUN composer clear-cache

# Run composer install with verbose and without --no-scripts, so post-install scripts can run properly
RUN composer install --no-dev --optimize-autoloader -vvv

# Laravel package discover (usually done during post-install scripts but safe to run explicitly)
RUN php artisan package:discover --ansi

# Set permissions for storage and cache
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
