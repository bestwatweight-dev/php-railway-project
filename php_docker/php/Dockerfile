FROM php:8.2-apache

# คัดลอกโค้ดทั้งหมดในโฟลเดอร์ php ไปยังเว็บรูทของ Apache
COPY . /var/www/html/

# ปรับพอร์ตของ Apache ให้เป็น 8080 (เพื่อให้ตรงกับที่ Nginx วิ่งมาหา)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# เปิดใช้งาน mod_rewrite หากจำเป็น
RUN a2enmod rewrite

EXPOSE 8080
