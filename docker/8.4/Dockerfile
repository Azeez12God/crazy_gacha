# Dockerfile
FROM ubuntu:24.04

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP
ARG NODE_VERSION=22
ARG MYSQL_CLIENT="mysql-client"
ARG POSTGRES_VERSION=17

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"
ENV SUPERVISOR_PHP_USER="sail"

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
 && echo $TZ > /etc/timezone

# Apt configuration
RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom \
 && echo "Acquire::http::No-Cache true;"  >> /etc/apt/apt.conf.d/99custom \
 && echo "Acquire::BrokenProxy true;"      >> /etc/apt/apt.conf.d/99custom

# Install core dependencies and add PPAs
RUN apt-get update \
 && apt-get upgrade -y \
 && apt-get install -y gnupg2 curl ca-certificates lsb-release software-properties-common \
 && add-apt-repository ppa:ondrej/php -y \
 && curl -fsSL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
 && curl -fsSL https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
 && echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list \
 && apt-get update

# Install PHP, Node, DB clients and other tools
RUN apt-get install -y \
    php8.4-cli php8.4-dev php8.4-pgsql php8.4-sqlite3 php8.4-gd \
    php8.4-curl php8.4-imap php8.4-mysql php8.4-mbstring php8.4-xml php8.4-zip php8.4-bcmath php8.4-soap php8.4-intl php8.4-readline php8.4-ldap \
    php8.4-msgpack php8.4-igbinary php8.4-redis php8.4-swoole php8.4-memcached php8.4-pcov php8.4-imagick php8.4-xdebug \
    nodejs yarn $MYSQL_CLIENT postgresql-client-$POSTGRES_VERSION supervisor sqlite3 libcap2-bin libpng-dev python3 dnsutils librsvg2-bin fswatch ffmpeg nano \
 && apt-get -y autoremove \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Ensure `php` points to php8.4
RUN update-alternatives --set php /usr/bin/php8.4

# Setup sail user
RUN groupadd --force -g $WWWGROUP sail \
 && useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

# Copy project & install deps
COPY . /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Laravel permissions
RUN mkdir -p storage/logs bootstrap/cache \
 && chown -R sail:sail storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Copy config and entrypoint
COPY docker/8.4/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/8.4/php.ini          /etc/php/8.4/cli/conf.d/99-sail.ini
COPY docker/8.4/start-container   /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

EXPOSE 80
ENTRYPOINT ["start-container"]
