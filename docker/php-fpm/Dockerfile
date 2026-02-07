FROM php:8.3-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libpq-dev git libicu-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev cron nodejs npm postgresql-client supervisor libzip-dev zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install exif \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install sysvmsg \
    && docker-php-ext-install sysvsem \
    && docker-php-ext-install sysvshm

# Install PNPM
RUN npm install --global corepack@latest && \
    corepack enable && \
    corepack prepare pnpm@latest-10

# Set pnpm store to /tmp to avoid EPERM on bind mounts
ENV PNPM_STORE_DIR=/tmp/pnpm-store

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r 'copy("https://composer.github.io/installer.sig", "composer-setup.sig");' && \
    EXPECTED_CHECKSUM="$(php -r 'echo file_get_contents("composer-setup.sig");')" && \
    ACTUAL_CHECKSUM="$(php -r 'echo hash_file("sha384", "composer-setup.php");')" && \
    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then \
        >&2 echo 'ERROR: Invalid installer checksum' && \
        exit 1; \
    fi && \
    php composer-setup.php --quiet && \
    rm composer-setup.php composer-setup.sig && \
    mv composer.phar /usr/local/bin/composer && \
    composer self-update

# Setup supervisor for Laravel Horizon
RUN mkdir -p /var/www/html/storage/logs
COPY supervisor/laravel.conf /etc/supervisor/conf.d/laravel.conf
RUN service supervisor start

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Berlin /etc/localtime
RUN "date"
RUN mkdir -p /var/www/html/storage/app/{invoices,estimates,media}
RUN touch /var/www/html/storage/logs/horizon.log
RUN chmod -R 777 /var/www/html/storage
# RUN chmod 777 /var/www/html/public

WORKDIR /var/www/html