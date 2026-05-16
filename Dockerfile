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
    npm \
    libxml2-dev \
    libsqlite3-dev

# Enable PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    zip \
    gd \
    mbstring \
    exif \
    xml \
    session \
    tokenizer \
    fileinfo

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader
RUN npm install && npm run build || true

# Create storage directories
RUN mkdir -p storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache \
    && chmod -R 755 public

# Enable Apache rewrite
RUN a2enmod rewrite

# Configure Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

# Clear any cached config (will be regenerated at runtime)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

EXPOSE 80

# Startup script
CMD sh -c "php artisan key:generate --force && \
           php artisan config:cache && \
           php artisan migrate --force && \
           apache2-foreground"ce && apache2-foreground"