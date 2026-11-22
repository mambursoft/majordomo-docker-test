FROM php:7.3-apache

# Old bullseye repositories are archived; point apt to archive.debian.org.
RUN printf 'deb http://archive.debian.org/debian bullseye main\n' > /etc/apt/sources.list \
 && printf 'deb http://archive.debian.org/debian-security bullseye-security main\n' >> /etc/apt/sources.list \
 && apt-get -o Acquire::Check-Valid-Until=false update \
 && apt-get install -y --no-install-recommends libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
 && docker-php-ext-install mysqli mbstring bcmath gd

RUN a2enmod rewrite
WORKDIR /var/www/html
