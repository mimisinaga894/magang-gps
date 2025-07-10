FROM php:8.2-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev \
    mysql-client \
    git \
    nodejs \
    npm \
    bash

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    gd \
    zip \
    opcache \
    bcmath \
    intl \
    mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Create user for Laravel application
ARG UID=1000
ARG GID=1000
RUN addgroup -g ${GID} www && \
    adduser -D -u ${UID} -G www www

# Change ownership of our applications
RUN chown -R www:www /var/www/html

# Switch to user
USER www

# Keep the container running
CMD ["bash"]
