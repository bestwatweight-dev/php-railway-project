FROM php:8.2-cli

# ติดตั้งส่วนเสริมฐานข้อมูล
RUN docker-php-ext-install mysqli pdo pdo_mysql

# คัดลอกไฟล์ทั้งหมด
COPY . /var/www/html/
WORKDIR /var/www/html

# ใช้พอร์ตที่ Railway กำหนด หรือ 8080 เป็นค่าเริ่มต้น
EXPOSE 8080

# รันด้วย PHP Built-in Server โดยตรง (ไม่ต้องง้อ Apache อีกต่อไป)
CMD ["php", "-S", "0.0.0.0:8080", "index.php"]
