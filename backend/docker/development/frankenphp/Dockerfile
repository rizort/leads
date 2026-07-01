FROM dunglas/frankenphp:1.12.4-php8-alpine

ENV XDG_CONFIG_HOME=/config
ENV XDG_DATA_HOME=/data

RUN install-php-extensions \
    bcmath \
    pdo_sqlite

RUN set -eux; \
    for attempt in 1 2 3 4 5; do \
        apk add --no-cache curl libcap shadow && break; \
        if [ "$attempt" -eq 5 ]; then exit 1; fi; \
        sleep 3; \
    done

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./common/frankenphp/Caddyfile /etc/caddy/Caddyfile

ARG UID=1000
ARG GID=1000

RUN addgroup -g "${GID}" app \
    && adduser -D -u "${UID}" -G app app \
    && mkdir -p /app /config/caddy /data/caddy \
    && setcap -r /usr/local/bin/frankenphp \
    && chown -R app:app /config/caddy /data/caddy /app

WORKDIR /app

USER app

ENTRYPOINT ["/usr/local/bin/frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]

HEALTHCHECK --interval=5s --timeout=3s --start-period=1s CMD curl --fail http://127.0.0.1:8080/health || exit 1
