FROM php:8.2-apache

RUN apt-get update && apt-get install -y git

RUN git clone https://github.com/ahassin96/myflix /var/www/html

EXPOSE 80
