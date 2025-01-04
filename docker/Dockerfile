FROM spiralscout/roadrunner:2024.3 as roadrunner
FROM ubuntu:22.04

ARG NODE_VERSION=20

WORKDIR /var/www/html

ENV TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN groupadd --force -g 1000 www &&  \
    useradd -u 1000 -ms /bin/bash -g www www

RUN apt update \
    && mkdir -p /etc/apt/keyrings \
    && apt install -y gnupg gosu curl ca-certificates zip unzip git supervisor libcap2-bin libpng-dev python2 dnsutils librsvg2-bin fswatch  \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt update \
    && apt install -y php8.3-fpm  \
    php8.3-cli  \
    php8.3-curl \
    php8.3-mysql \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-zip  \
    php8.3-bcmath  \
    php8.3-intl  \
    php8.3-readline \
    php8.3-redis \
    php8.3-xdebug \
    vim \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt update \
    && apt install -y nodejs \
    && npm install -g npm \
    && apt install -y mysql-client \
    && apt -y autoremove \
    && apt clean \
    && rm -rf /tmp/* /var/tmp/*

COPY --from=roadrunner /usr/bin/rr /usr/bin/rr
COPY php.ini /etc/php/8.3/cli/conf.d/99-php.ini

EXPOSE ${OCTANE_PORT:-8000}
EXPOSE 6001

USER www
CMD ["php8.3", "artisan", "octane:start"]
