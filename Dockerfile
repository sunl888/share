FROM php:7.2-fpm-alpine3.7

#替换国内镜像
COPY deploy/source.list /etc/apk/repositories

RUN apk update && apk --no-cache add freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev curl zlib-dev ffmpeg \
 && docker-php-ext-configure gd \
  --with-gd \
  --with-freetype-dir=/usr/include/ \
  --with-png-dir=/usr/include/ \
  --with-jpeg-dir=/usr/include/ \
  --with-zlib-dir=/usr \
 && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
 && docker-php-ext-install -j${NPROC} gd zip pdo_mysql mbstring opcache \
 && docker-php-ext-enable opcache \
 && apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

RUN echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini" \
 && echo "date.timezone=${PHP_TIMEZONE:-UTC}" > "$PHP_INI_DIR/conf.d/date_timezone.ini"
COPY ./deploy/opcache.dev.ini ${PHP_INI_DIR}/conf.d/opcache.dev.ini

WORKDIR /var/www/

CMD ["/var/www/deploy/docker-entrypoint-dev.sh"]