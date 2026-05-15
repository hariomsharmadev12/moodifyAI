FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    nodejs \
    npm

# Enable PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    zip \
    gd \
    mbstring \
    exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install
RUN npm run build

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Create Laravel log file
RUN mkdir -p storage/logs
RUN touch storage/logs/laravel.log

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
RUN chmod -R 775 storage/logs

# Public assets permissions
RUN chmod -R 755 public

# Clear and cache Laravel config
RUN php artisan optimize:clear || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 80

# Start Laravel + Apache
CMD sh -c "php artisan migrate --force && apache2-foreground"