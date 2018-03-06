FROM nidarbox/php:7.0-cli

MAINTAINER Jesus Farfan <jesu.farfan23@gmail.com>

ADD . /app

WORKDIR /app

RUN composer install

