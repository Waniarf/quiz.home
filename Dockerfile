# Use an official PHP image as a parent image
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    # PHP extensions
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    zip \
    intl \
    ctype \
    iconv \
    opcache \
    # Install APCu
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    # Clean up
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /app

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /app

# Expose port 9000 and start php-fpm server (if you were running a web server, otherwise CMD can be different)
# For a CLI application or just for composer install/update, you might not need to expose a port or run php-fpm.
# If this project runs as a web application, you'll need a web server like Nginx or Apache
# and configure it to use PHP-FPM. For now, this Dockerfile focuses on CLI tasks like composer.

# The default command can be to run composer install, or just leave it to be specified at runtime.
# For example, to ensure dependencies are installed when the image is built:
# RUN composer install --no-scripts --no-autoloader
# Then, later, when running a container:
# CMD ["composer", "run-script", "auto-scripts"]

# For now, we will not run composer install/update during the build,
# as the user will run it manually after building the image.

# Configure PHP for development (optional)
# You might want to copy a custom php.ini file for development settings
# RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
# RUN echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini
# RUN echo "date.timezone=UTC" >> /usr/local/etc/php/conf.d/docker-php-timezone.ini

# Add a non-root user for security (optional but recommended)
# RUN groupadd -g 1000 appuser && \
#     useradd -u 1000 -g appuser -ms /bin/bash -d /app appuser
# USER appuser

# The container will by default start a shell, or you can specify a command.
CMD ["bash"]
