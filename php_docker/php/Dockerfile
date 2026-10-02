FROM php:8.2-apache

# ปิดโมดูล MPM ทั้งหมดก่อน แล้วบังคับเปิดเฉพาะ prefork เท่านั้นเพื่อตัดปัญหาขัดแย้ง
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load \
    && rm -f /etc/apache2/mods-enabled/mpm_*.conf \
    && a2enmod mpm_prefork

# ติดตั้งส่วนเสริมฐานข้อมูล
RUN docker-php-ext-install mysqli pdo pdo_mysql

# คัดลอกไฟล์ทั้งหมด
COPY . /var/www/html/

# จัดการไฟล์ start.sh
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["/usr/local/bin/start.sh"]
