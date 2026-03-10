FROM php:8.2-fpm-bullseye

#ARG USER_ID=33
#ARG GROUP_ID=33

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libxml2-dev \
    libxslt1-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    soap

# Install Redis extension (optional, but often needed)
# RUN pecl install redis && docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Change  user and group for working dir(fallback)
# RUN groupadd --force -g $GROUP_ID html && \
#    useradd -ms /bin/bash --no-user-group -g $GROUP_ID -u $USER_ID html

# Set working directory
WORKDIR /var/www/html

# Copy php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

#COPY setup.sh ./

USER www-data

EXPOSE 9000
#CMD ["php-fpm"]

# will trig in setup.sh file.
# CMD ["./setup.sh"]
