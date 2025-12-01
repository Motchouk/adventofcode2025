# Base PHP CLI image for running Symfony commands
FROM php:8.2-cli AS php_base

WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Allow Composer to run as superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# Development stage
FROM php_base AS php_dev

ENV APP_ENV=dev

# Copy PHP configuration
COPY php.ini $PHP_INI_DIR/conf.d/app.ini

# Default command (keep container alive for executing commands)
CMD ["tail", "-f", "/dev/null"]
