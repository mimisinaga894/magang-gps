# Base production image
FROM php:8.4-fpm-alpine AS production

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    icu-dev \
    mysql-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    autoconf \
    g++ \
    make

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    zip \
    intl \
    gd \
    bcmath \
    opcache

RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .
RUN mkdir -p bootstrap/cache && chmod -R 777 bootstrap/cache

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000
EXPOSE 9000

# Development layer
FROM production AS development

# Install build dependencies for Xdebug
RUN apk add --no-cache autoconf g++ make linux-headers

# Install Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configure development
ENV XDEBUG_MODE=develop,coverage,debug,profile
ENV XDEBUG_HOST=host.docker.internal
ENV XDEBUG_IDE_KEY=DOCKER

# Add user
RUN addgroup -g 1000 www \
    && adduser -D -u 1000 -G www www

# Switch to working directory
WORKDIR /var/www

CMD ["php-fpm"]
