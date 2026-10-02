FROM nginx:alpine

# ก๊อปปี้ default.conf ไปไว้ในโฟลเดอร์ templates
# เพื่อให้ Nginx ดึงตัวแปร $PORT จาก Railway ไปใส่แทนที่อัตโนมัติ
COPY default.conf /etc/nginx/templates/default.conf.template
