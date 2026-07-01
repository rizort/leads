FROM php:8.4-cli-alpine3.23

RUN set -eux; \
    for attempt in 1 2 3 4 5; do \
        apk add --no-cache sqlite-dev bash coreutils && break; \
        if [ "$attempt" -eq 5 ]; then exit 1; fi; \
        sleep 3; \
    done; \
    docker-php-ext-install pcntl pdo_sqlite bcmath

RUN set -eux; \
    for attempt in 1 2 3 4 5; do \
        apk add --no-cache --virtual .build-deps \
            $PHPIZE_DEPS \
            zlib-dev && break; \
        if [ "$attempt" -eq 5 ]; then exit 1; fi; \
        sleep 3; \
    done; \
    apk del .build-deps

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php/conf.d /usr/local/etc/php/conf.d

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --version=2.9.1 --quiet

ARG UID=1000
ARG GID=1000

RUN addgroup -g "${GID}" app && adduser -u "${UID}" -G app -s /bin/sh -D app

WORKDIR /app

USER app
