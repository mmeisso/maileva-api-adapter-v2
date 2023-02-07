#syntax=docker/dockerfile:1.4
FROM webdevops/php-dev:7.4 as base
ENV APP_ENV=test

WORKDIR /app

RUN apt-install pdftk poppler-utils \
    && docker-run-bootstrap \
    && docker-image-cleanup;

FROM base as app

USER application
COPY --link ./ /app
USER root

RUN echo "xdebug.mode = coverage" >> /opt/docker/etc/php/php.ini

FROM app as test

# because entrypoint auto elevate privileges
CMD gosu application \
    php vendor/bin/codecept run unit;
