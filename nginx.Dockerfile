FROM nginx:alpine

RUN sed -i 's/worker_processes  auto;/worker_processes 4;/' /etc/nginx/nginx.conf \
	&& mkdir -p /var/www/html
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY ./src/ /var/www/html/
