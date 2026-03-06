FROM php:8.4-cli

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y unzip git
RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install

RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear

RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

CMD php -S 0.0.0.0:10000 -t public
