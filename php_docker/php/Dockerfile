FROM php:8.2-cli

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html/
WORKDIR /var/www/html

CMD ["sh", "-c", "php -S [::]:${PORT:-8080} -t /var/www/html"]
