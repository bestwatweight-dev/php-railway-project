FROM php:8.2-apache

COPY . /var/www/html/

# เคลียร์โมดูล MPM ที่ชนกัน
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load \
    && rm -f /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.conf

RUN a2enmod mpm_prefork

# คัดลอกและกำหนดสิทธิ์ให้ไฟล์ start.sh
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 8080

# รันผ่านสคริปต์ที่เรากำหนด
CMD ["/usr/local/bin/start.sh"]
