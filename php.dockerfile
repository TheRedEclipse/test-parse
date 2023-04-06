FROM php:8.1-fpm-alpine

ARG APP_PATH_HOST_BACK

ARG APP_PATH_CONTAINER_BACK

WORKDIR ${APP_PATH_CONTAINER_BACK}

COPY ${APP_PATH_HOST_BACK} .

RUN apk update
RUN apk add --no-cache freetype-dev
RUN apk add --no-cache libjpeg-turbo-dev libpng-dev
RUN apk add --no-cache  \
		libzip-dev libxml2-dev icu-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd zip mysqli pdo pdo_mysql xml intl
RUN docker-php-ext-enable pdo_mysql
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN apk add --no-cache shadow