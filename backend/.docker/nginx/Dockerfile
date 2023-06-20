FROM nginx:1.23-alpine-slim

COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY public /application/public

ENTRYPOINT ["nginx", "-g", "daemon off;"]
