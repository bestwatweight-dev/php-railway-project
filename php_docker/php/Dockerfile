FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# ลบไฟล์เปิดใช้งาน MPM ตัวอื่นๆ ทิ้งให้หมดจาก mods-enabled ป้องกันการโหลดซ้ำ
RUN rm -f /etc/apache2/mods-enabled/mpm_event.* \
    /etc/apache2/mods-enabled/mpm_worker.* \
    /etc/apache2/mods-enabled/mpm_prefork.*

# เปิดใช้งาน mpm_prefork เพียงตัวเดียวแบบระบุไฟล์
RUN ln -s /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/ \
    && ln -s /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/

# เปลี่ยนพอร์ตในไฟล์ ports.conf และ 000-default.conf ให้เป็น 8080
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf
