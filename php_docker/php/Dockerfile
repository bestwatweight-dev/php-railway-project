FROM php:8.2-apache

COPY . /var/www/html/

# ลบโมดูล MPM ที่ชนกัน
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.conf

RUN a2enmod mpm_prefork

# ตั้งค่าให้ Apache ฟังพอร์ตตามที่ Railway กำหนดผ่านตัวแปร ${PORT} (หรือใช้ 8080 เป็นค่าสำรอง)
RUN sed -i "s/80/\${PORT:-8080}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080
