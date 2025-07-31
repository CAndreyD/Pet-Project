FROM php:8.3-fpm

# Установка зависимостей и расширений
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install zip pdo pdo_mysql
# Установка Xdebug  
RUN pecl install xdebug \
&& docker-php-ext-enable xdebug

COPY ./docker/php/conf.d/ /usr/local/etc/php/conf.d/

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем composer.json и устанавливаем зависимости (для кеша)
# COPY composer.json composer.lock ./
# RUN composer install --no-dev --optimize-autoloader

# Копируем весь проект
COPY . .

# Права на storage и bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache
RUN touch /tmp/xdebug.log && chown www-data:www-data /tmp/xdebug.log

CMD ["php-fpm"]
