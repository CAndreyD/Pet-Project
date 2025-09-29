FROM php:8.3-fpm-bookworm

ENV DEBIAN_FRONTEND=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1

# --- Системные зависимости и Node.js ---
RUN apt-get update \
  && apt-get install -y ca-certificates curl gnupg git unzip libzip-dev zip build-essential nano \
  && docker-php-ext-install zip pdo pdo_mysql \
  && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
  && apt-get install -y nodejs \
  && npm install -g npm@latest \
  && rm -rf /var/lib/apt/lists/*

RUN pecl install redis \
  && docker-php-ext-enable redis
# --- Xdebug ---
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug
COPY ./docker/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# --- Composer ---
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# --- Копируем зависимости ---
COPY composer.json composer.lock ./ 
COPY package*.json ./

# --- Composer install с кешем ---
RUN --mount=type=cache,target=/root/.composer \
  composer install --no-scripts --prefer-dist --no-interaction --no-progress --optimize-autoloader

# --- NPM install с кешем ---
RUN --mount=type=cache,target=/root/.npm \
  npm ci --no-audit --no-progress || true

# --- Копируем весь проект ---
COPY . .

# --- Создание tailwind.config.js вручную (если нужно) ---
# COPY tailwind.config.js postcss.config.js ./  

# --- Права ---
RUN chown -R www-data:www-data storage bootstrap/cache \
  && touch /tmp/xdebug.log \
  && chown www-data:www-data /tmp/xdebug.log \
  && chmod -R 777 /tmp/

CMD ["php-fpm"]
