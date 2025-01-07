
FROM php:8.2-fpm
WORKDIR /var/www/html

COPY . .

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git && \
    docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN composer install

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
