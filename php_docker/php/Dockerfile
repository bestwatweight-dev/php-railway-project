FROM php:8.2-cli

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/
WORKDIR /var/www/html

CMD ["sh", "-c", "php -S [::]:${PORT:-8080} -t /var/www/html"]
