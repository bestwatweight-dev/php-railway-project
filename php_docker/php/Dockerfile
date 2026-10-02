FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# ลบไฟล์ลิงก์ของ MPM ตัวที่ไม่ได้ใช้ออกจาก mods-enabled โดยตรง เพื่อป้องกันการโหลดซ้ำ
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    /etc/apache2/mods-enabled/mpm_event.conf \
    /etc/apache2/mods-enabled/mpm_worker.load \
    /etc/apache2/mods-enabled/mpm_worker.conf

# เปิดใช้งาน mpm_prefork เพียงตัวเดียว
RUN a2enmod mpm_prefork
