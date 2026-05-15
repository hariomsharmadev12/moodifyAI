FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    nodejs \
    npm

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

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN chmod -R 755 public
RUN chmod -R 777 storage bootstrap/cache

RUN php artisan optimize:clear || true

EXPOSE 80

CMD sh -c "php artisan migrate --force && apache2-foreground"