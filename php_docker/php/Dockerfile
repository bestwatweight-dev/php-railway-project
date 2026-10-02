FROM php:8.2-apache

# คัดลอกโค้ดทั้งหมด
COPY . /var/www/html/

# ลบโมดูล MPM ที่ไม่ใช้ออกให้หมด เหลือไว้แค่อันเดียว (prefork)
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.conf

# เปิดใช้งาน mpm_prefork อย่างชัดเจน
RUN a2enmod mpm_prefork

# ปรับพอร์ตเป็น 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080
