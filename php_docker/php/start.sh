#!/bin/bash
# แทนที่เลขพอร์ต 80 ในไฟล์คอนฟิกของ apache ให้เป็นพอร์ตที่ Railway กำหนด ($PORT)
sed -i "s/80/${PORT:-8080}/g" /etc/apache2/ports.conf
sed -i "s/80/${PORT:-8080}/g" /etc/apache2/sites-available/000-default.conf

# รัน Apache ใน foreground
apache2-foreground
