FROM dunglas/frankenphp:latest

# Установим необходимые пакеты и расширения
RUN apt-get update && \
    apt-get install -y git unzip libpq-dev libzip-dev zip curl && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip sockets pcntl

# Устанавливаем Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем composer.json и composer.lock
COPY composer.json composer.lock ./

RUN composer install --no-interaction --prefer-dist --no-scripts

# Копируем остальные файлы проекта
COPY . .

# Генерируем app key если нет .env
RUN if [ ! -f .env ]; then cp .env.example .env; fi && \
    php artisan key:generate || true

# Права на storage и cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Копируем entrypoint и исправляем окончания строк
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh && \
    chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["docker-entrypoint.sh"]
