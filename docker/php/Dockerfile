FROM php:8-fpm-alpine

# Instalar extensões necessárias
RUN set -ex; \
    apk add --no-cache \
        sqlite \
        sqlite-dev \
        libzip-dev \
        zip \
        unzip \
        shadow \
        curl; \
    # Instalar extensões PHP
    docker-php-ext-install \
        pdo_sqlite \
        zip

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar diretório de dados
RUN mkdir -p /var/www/html/data /var/www/uploads && \
    chown -R www-data:www-data /var/www/html/data /var/www/uploads && \
    chmod -R 775 /var/www/html/data /var/www/uploads

# Aumentar limite de upload
COPY php.ini /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

# Adicionar script de inicialização para configurar permissões
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]