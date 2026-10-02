FROM php:8.1-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# ปิดโมดูล MPM ทั้งหมดก่อน แล้วบังคับเปิดแค่ mpm_prefork ตัวเดียว
RUN a2dismod -f mpm_event mpm_worker mpm_prefork || true
RUN a2enmod mpm_prefork
