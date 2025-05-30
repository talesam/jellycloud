#!/bin/sh
set -e

# Obter o UID e GID do diretório de volume montado
HOST_UID=$(stat -c '%u' /var/www/html)
HOST_GID=$(stat -c '%g' /var/www/html)

# Criar ou modificar grupo para corresponder ao GID do host
if getent group $HOST_GID > /dev/null; then
    GROUP_NAME=$(getent group $HOST_GID | cut -d: -f1)
else
    GROUP_NAME=hostgroup
    addgroup -g $HOST_GID $GROUP_NAME
fi

# Garantir que www-data pertence ao grupo do host para permissões adequadas
adduser www-data $GROUP_NAME

# Garantir que o diretório de dados existe e tem permissões corretas
mkdir -p /var/www/html/data
touch /var/www/html/data/jellycloud.sqlite
chown -R www-data:$GROUP_NAME /var/www/html/data
chmod -R 775 /var/www/html/data
chmod 664 /var/www/html/data/jellycloud.sqlite

# Garantir que o diretório de uploads existe e tem permissões corretas
mkdir -p /var/www/html/uploads
chown -R www-data:$GROUP_NAME /var/www/html/uploads
chmod -R 775 /var/www/html/uploads

# Garantir que o diretório de logs existe e tem permissões corretas
mkdir -p /var/www/html/logs
touch /var/www/html/logs/upload_debug.log
chown -R www-data:$GROUP_NAME /var/www/html/logs
chmod -R 775 /var/www/html/logs
chmod 664 /var/www/html/logs/upload_debug.log

# Executar o comando fornecido (normalmente php-fpm)
exec "$@"
