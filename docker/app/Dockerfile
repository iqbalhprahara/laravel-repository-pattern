FROM php:8.3-cli-alpine3.20 as base

LABEL maintainer="Iqbal Hikmat Prahara"

ARG WWWGROUP
ARG WWWUSER

# Set System Default Timezone
ENV TZ='Asia/Jakarta'

# Install required package
RUN apk --update --no-cache add tzdata jq npm shadow openssl

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases//download/2.2.16/install-php-extensions /usr/local/bin/

# Install php extensions
RUN install-php-extensions pdo_pgsql \
    swoole-5.1.1 \
    pcntl \
    gd \
    imagick/imagick@master \
    exif \
    bcmath \
    redis \
    intl \
    zip \
    @composer

# Install PM2
RUN npm install pm2 -g

# Configure php.ini
COPY ./app.ini /usr/local/etc/php/conf.d/

# Clean up
RUN rm -rf /var/cache/apk/* /usr/local/bin/install-php-extensions

######################################
#       DEVCONTAINER WORKSPACE       #
######################################
FROM base as devcontainer

RUN apk --update --no-cache add git \
    zsh \
    nano \
    make \
    openssh

# Configure non-root user for development
RUN set -xe; \
    addgroup -g ${WWWGROUP} -S developer; \
    adduser -u ${WWWUSER} -S -G developer developer -D -s zsh

# Configure Oh MyZsh & Git
USER developer

RUN set -xe; \
    cd ~ && \
    sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"

RUN git config --global core.editor "nano"

USER root

# Clean up
RUN apk del shadow
RUN rm -rf /var/cache/apk/*

################################
#            APP               #
################################
FROM build as app

RUN apk --update --no-cache add shadow

RUN set -eux; \
    groupmod --gid ${WWWGROUP} www-data; \
    usermod --uid ${WWWUSER} --gid ${WWWGROUP} www-data

# Clean up
RUN apk del shadow
RUN rm -rf /var/cache/apk/*
