FROM php:8.2-apache

# 1. Force the image init script to stick purely to prefork behavior up front
ENV APACHE_MPM=prefork
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# 2. Install system dependencies
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
    cron \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Install core PHP extensions required by Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    zip \
    gd \
    mbstring \
    exif \
    xml

# 4. Pull official Composer binary
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 5. Establish working environment
WORKDIR /var/www/html

# 6. Copy all project source files
COPY . /var/www/html

# 7. Create explicit infrastructure directories for Laravel 
RUN mkdir -p storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

# 8. Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 9. Compile frontend assets (Vite/Mix)
RUN npm install --no-audit --no-fund && npm run build || true

# 10. CRITICAL FIX: Update ownership of EVERYTHING including vendor/build files 
# This prevents 403 / 500 permission crashes when Apache boots up
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 11. Enable Apache rewrite engine
RUN a2enmod rewrite

# 12. Decisive fix for the MPM crash loop
RUN sed -i 's/^LoadModule mpm_event_module/# LoadModule mpm_event_module/' /etc/apache2/mods-available/mpm_event.load || true \
    && a2dismod mpm_event || true \
    && a2enmod mpm_prefork || true

# 13. Reconfigure Apache to point cleanly to the Laravel public/ folder
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 14. Network exposition
EXPOSE 80

# 15. Execution entrypoint
CMD ["apache2-foreground"]