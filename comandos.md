# JellyCloud - Comandos Docker

## Acessar container PHP
```bash
docker exec -it jellyphp sh
```

## Comandos Composer
```bash
docker-compose run --rm jellyphp composer install
docker-compose run --rm jellyphp composer dump-autoload --no-dev
```

## Build e execução
```bash
# Build dos containers
docker-compose build

# Subir os serviços
docker-compose up -d

# Ver logs
docker-compose logs -f

# Parar os serviços
docker-compose down
```

## Comandos úteis
```bash
# Verificar status dos containers
docker-compose ps

# Recriar containers
docker-compose up -d --force-recreate

# Remover volumes órfãos
docker volume prune
```