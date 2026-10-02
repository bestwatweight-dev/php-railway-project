#!/bin/bash
# แทนที่พอร์ต 80 ในคอนฟิกของ apache ให้ตรงกับพอร์ตที่ Railway กำหนด ($PORT)
sed -i "s/80/${PORT:-8080}/g" /etc/apache2/ports.conf
sed -i "s/80/${PORT:-8080}/g" /etc/apache2/sites-available/000-default.conf

# บังคับให้ Apache ฟังทุก IP บนพอร์ตที่กำหนด
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# รัน Apache ในโหมด foreground
exec apache2-foreground
