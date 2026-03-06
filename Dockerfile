FROM php:8.4-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y unzip git
RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public
