FROM php:8.2-apache
COPY . /var/www/html/
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf
EXPOSE 8080
