FROM nginx:alpine

# บังคับเปลี่ยนเฉพาะตัวแปร PORT เพื่อไม่ให้ $host ของ Nginx เสียหาย
ENV NGINX_ENVSUBST_FILTER=PORT

COPY default.conf /etc/nginx/templates/default.conf.template
