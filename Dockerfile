FROM php:8.3-apache

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install Additional System Dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get -y update \
    && apt-get -y install git zlib1g-dev libzip-dev unzip \
    && a2enmod rewrite \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && pecl install xdebug-3.3.1 \
    && docker-php-ext-enable xdebug
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer





# Configure Apache DocumentRoot to point to Laravel's public directory
# and update Apache configuration files
ENV APACHE_DOCUMENT_ROOT=/var/www/html/twinkl/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


# Copy the application code
COPY . /var/www/html

# we need a user with the same UID/GID with host user
# so when we execute CLI commands, all the host file's ownership remains intact
# otherwise command from inside container will create root-owned files and directories

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

#RUN find /var/www -type d -exec chmod 0775 '{}' \;
# Set permissions
RUN chmod -R 0775 /var/www
RUN chown -R $user:$user /var/www


# Set working directory
WORKDIR /var/www/html/twinkl

# Install project dependencies
#RUN composer install



USER $user
