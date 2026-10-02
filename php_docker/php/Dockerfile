FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# ลบโมดูล MPM ตัวที่ไม่ได้ใช้ และเปิด mpm_prefork
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    /etc/apache2/mods-enabled/mpm_event.conf \
    /etc/apache2/mods-enabled/mpm_worker.load \
    /etc/apache2/mods-enabled/mpm_worker.conf
RUN a2enmod mpm_prefork

# เปลี่ยนพอร์ตของ Apache ให้ฟังที่พอร์ต 8080 ตามที่ Railway กำหนด
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
