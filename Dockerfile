FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy project files into Apache root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install MySQL extension
RUN docker-php-ext-install mysqli
