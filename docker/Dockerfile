FROM php:7.3-fpm

LABEL Maintainer="Ismail Youmbissie Fouapon" \
      Description="Docker Nginx PHP MySQL, Sprint-2, SE2 polito"

# Copy composer.lock and composer.json
# COPY composer.lock composer.json /var/www/

# Set working directory
#WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mariadb-client \
    libpng-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    cron \
    supervisor \
	nginx


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www



# Configure nginx
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

RUN ls /etc/nginx
RUN cat /etc/nginx/nginx.conf

# Copy php config
COPY ./php/local.ini /usr/local/etc/php/conf.d/local.ini

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN git clone --single-branch --branch "sprint-2" https://github.com/SaharSaadatmandi/school .
RUN rm * -frv && git clone https://github.com/SaharSaadatmandi/school . && composer install && ls

COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./.env /var/www/html/.env
RUN php artisan key:generate
RUN chown www:www /var/www && chmod -R 777 /var/www/html/*

# Change current user to www
# USER www

EXPOSE 80

CMD /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf