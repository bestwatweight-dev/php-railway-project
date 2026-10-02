FROM php:8.2-cli

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/
WORKDIR /var/www/html

# ใช้ $PORT ที่ Railway ส่งมา หากไม่มีให้ใช้ 8080
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080}"]
