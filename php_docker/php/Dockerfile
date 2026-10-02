FROM php:8.2-apache

COPY . /var/www/html/

RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork

# บังคับเปลี่ยนพอร์ตเป็น 8080 ทุกจุด
RUN sed -i 's/:80/:8080/g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf

EXPOSE 8080
