FROM almalinux:8

RUN dnf install -y httpd
RUN dnf module install -y php:7.4
RUN mkdir /run/php-fpm
RUN dnf install -y php-mysqlnd

COPY httpd.conf /etc/httpd/conf.d/httpd.conf

WORKDIR /var/www/html

EXPOSE 80

CMD php-fpm -D; /usr/sbin/httpd -D FOREGROUND