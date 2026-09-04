FROM php:8.2-cli-alpine

RUN apk add --no-cache \
    git \
    curl \
    postgresql-dev \
    icu-dev \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    supervisor \
    bash

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-install pdo pdo_pgsql pgsql pcntl bcmath intl zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/sendportal

RUN git clone --depth 1 https://github.com/mettle/sendportal.git . \
    && cp .env.example .env \
    && composer remove --dev --no-update roave/security-advisories \
    && composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

COPY supervisord.conf /etc/supervisord.conf
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN chown -R www-data:www-data /var/www/sendportal/storage /var/www/sendportal/bootstrap/cache

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
