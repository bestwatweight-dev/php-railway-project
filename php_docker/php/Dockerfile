FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# ปิดและถอดถอน MPM ตัวที่ไม่ได้ใช้อย่างถูกต้องผ่านคำสั่งของ Apache
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork

# เปลี่ยนพอร์ตในไฟล์ ports.conf และ 000-default.conf ให้เป็น 8080
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf
