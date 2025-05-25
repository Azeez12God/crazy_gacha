FROM ubuntu:24.04

LABEL maintainer="Taylor Otwell"

ARG WWWGROUP
ARG NODE_VERSION=22
ARG MYSQL_CLIENT="mysql-client"
ARG POSTGRES_VERSION=17

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
# Puerto en el que listenaremos
ENV APP_PORT=8087

# 1) Zona horaria
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
  && echo $TZ > /etc/timezone

# 2) Dependencias de sistema
RUN echo "Acquire::http::Pipeline-Depth 0;"     > /etc/apt/apt.conf.d/99custom \
  && echo "Acquire::http::No-Cache true;"      >> /etc/apt/apt.conf.d/99custom \
  && echo "Acquire::BrokenProxy true;"         >> /etc/apt/apt.conf.d/99custom \
  && apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y \
       gnupg \
       gosu \
       curl \
       ca-certificates \
       zip \
       unzip \
       git \
       sqlite3 \
       libcap2-bin \
       libpng-dev \
       python3 \
       dnsutils \
       librsvg2-bin \
       fswatch \
       ffmpeg \
       nano \
  && rm -rf /var/lib/apt/lists/*

# 3) PHP + Composer
RUN curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xb8dc7e53946656efbce4c1dd71daeaab4ad4cab6' \
    | gpg --dearmor \
    | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
  && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu noble main" \
    > /etc/apt/sources.list.d/ppa_ondrej_php.list \
  && apt-get update \
  && apt-get install -y \
       php8.4-cli \
       php8.4-pgsql \
       php8.4-sqlite3 \
       php8.4-gd \
       php8.4-curl \
       php8.4-mbstring \
       php8.4-xml \
       php8.4-zip \
       php8.4-bcmath \
       php8.4-intl \
       php8.4-readline \
       php8.4-redis \
       php8.4-xdebug \
  && curl -sSL https://getcomposer.org/installer \
       | php -- --install-dir=/usr/bin --filename=composer \
  && rm -rf /var/lib/apt/lists/*

# 4) Node.js, pnpm, bun
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key \
      | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
  && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" \
      > /etc/apt/sources.list.d/nodesource.list \
  && apt-get update \
  && apt-get install -y nodejs \
  && npm install -g npm pnpm bun \
  && rm -rf /var/lib/apt/lists/*

# 5) Yarn y clientes de BBDD
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg \
      | gpg --dearmor \
      | tee /etc/apt/keyrings/yarn.gpg > /dev/null \
  && echo "deb [signed-by=/etc/apt/keyrings/yarn.gpg] https://dl.yarnpkg.com/debian/ stable main" \
      > /etc/apt/sources.list.d/yarn.list \
  && curl -sS https://www.postgresql.org/media/keys/ACCC4CF8.asc \
      | gpg --dearmor \
      | tee /etc/apt/keyrings/pgdg.gpg > /dev/null \
  && echo "deb [signed-by=/etc/apt/keyrings/pgdg.gpg] http://apt.postgresql.org/pub/repos/apt noble-pgdg main" \
      > /etc/apt/sources.list.d/pgdg.list \
  && apt-get update \
  && apt-get install -y yarn $MYSQL_CLIENT postgresql-client-$POSTGRES_VERSION \
  && rm -rf /var/lib/apt/lists/*

# 6) Usuario sail
RUN groupadd --force -g $WWWGROUP sail \
  && useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

# 7) Directorios Laravel
RUN mkdir -p storage/logs bootstrap/cache \
  && chown -R sail:sail storage bootstrap \
  && chmod -R 775 storage bootstrap

# 8) Copia código y dependencias
COPY --chown=sail:sail . /var/www/html
RUN composer install --no-dev --optimize-autoloader

# 9) SQLite (opcional si lo usas)
# RUN touch database.sqlite \
#   && chmod 666 database.sqlite

# 10) Exponer puerto y arrancar como sail
USER sail
EXPOSE ${APP_PORT}
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8087"]
