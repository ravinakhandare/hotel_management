# Use official PHP-Apache image
FROM php:8.2-apache

# Install MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy your website files
COPY . /var/www/html/

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose port 80 for web traffic
EXPOSE 80