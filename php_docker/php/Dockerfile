FROM php:8.2-apache

# คัดลอกโค้ดทั้งหมดไปยังเว็บรูท
COPY . /var/www/html/

# ปิดใช้งาน MPM ตัวเก่า (event/worker) แล้วเปิด prefork ป้องกัน Error เรื่อง More than one MPM loaded
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork

# ปรับพอร์ตของ Apache ให้เป็น 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080
