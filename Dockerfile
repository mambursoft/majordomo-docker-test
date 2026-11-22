FROM php:7.3-apache

# Minimal extension set for MajorDoMo; no apt mirror dependency (old bullseye repos are stale).
RUN docker-php-ext-install mysqli mbstring bcmath

RUN a2enmod rewrite
WORKDIR /var/www/html
