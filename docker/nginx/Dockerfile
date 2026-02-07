FROM nginx:1.22.1

COPY default.conf /etc/nginx/conf.d/
RUN mkdir -p /etc/ssl/
COPY configssl /etc/ssl/configssl
RUN mkdir -p /etc/nginx/ssl/localhost
RUN openssl req -x509 -out /etc/nginx/ssl/localhost/localhost.crt -keyout /etc/nginx/ssl/localhost/localhost.key \
  -newkey rsa:2048 -nodes -sha256 \
  -subj '/CN=fzk.test' -extensions EXT -config /etc/ssl/configssl \
