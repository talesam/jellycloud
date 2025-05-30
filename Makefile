# JellyCloud Makefile
# Comandos para facilitar desenvolvimento e deploy

.PHONY: help build up down restart logs shell clean install deploy test backup restore

# Default target
help: ## Mostra esta mensagem de ajuda
	@echo "🍇 JellyCloud - Comandos Disponíveis"
	@echo "=================================="
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

# Development Commands
build: ## Constrói os containers Docker
	@echo "🔨 Construindo containers do JellyCloud..."
	docker-compose build --no-cache

up: ## Sobe os containers em modo desenvolvimento
	@echo "🚀 Iniciando JellyCloud..."
	docker-compose up -d
	@echo "✅ JellyCloud rodando em http://localhost"

down: ## Para os containers
	@echo "🛑 Parando JellyCloud..."
	docker-compose down

restart: ## Reinicia os containers
	@echo "🔄 Reiniciando JellyCloud..."
	$(MAKE) down
	$(MAKE) up

logs: ## Mostra os logs dos containers
	@echo "📋 Logs do JellyCloud:"
	docker-compose logs -f

logs-php: ## Mostra apenas os logs do PHP
	docker-compose logs -f jellyphp

logs-nginx: ## Mostra apenas os logs do Nginx
	docker-compose logs -f jellycloud

shell: ## Acessa o shell do container PHP
	@echo "🐚 Acessando shell do container PHP..."
	docker-compose exec jellyphp sh

shell-nginx: ## Acessa o shell do container Nginx
	docker-compose exec jellycloud sh

# Installation Commands
install: ## Instala dependências (primeira configuração)
	@echo "📦 Instalando JellyCloud..."
	cp -n .env.example .env || true
	$(MAKE) build
	$(MAKE) up
	@echo "⏳ Aguardando containers..."
	sleep 5
	docker-compose exec jellyphp composer install
	docker-compose exec jellyphp composer dump-autoload --optimize
	@echo "🎉 JellyCloud instalado com sucesso!"
	@echo "🌐 Acesse: http://localhost"

composer-install: ## Instala dependências do Composer
	docker-compose exec jellyphp composer install

composer-update: ## Atualiza dependências do Composer
	docker-compose exec jellyphp composer update

composer-dump: ## Regenera autoload do Composer
	docker-compose exec jellyphp composer dump-autoload --optimize

# Production Commands
deploy-prod: ## Deploy em produção
	@echo "🚀 Fazendo deploy em produção..."
	docker-compose -f docker-compose.prod.yml pull
	docker-compose -f docker-compose.prod.yml up -d --build
	@echo "✅ Deploy de produção concluído!"

prod-logs: ## Mostra logs de produção
	docker-compose -f docker-compose.prod.yml logs -f

prod-down: ## Para containers de produção
	docker-compose -f docker-compose.prod.yml down

# Database Commands
db-populate: ## Popula o banco com dados de teste
	@echo "📊 Populando banco de dados..."
	docker-compose exec jellyphp php scripts/populaDb.php

db-backup: ## Faz backup do banco de dados
	@echo "💾 Fazendo backup do banco..."
	mkdir -p backups
	docker-compose exec jellyphp cp /var/www/html/data/jellycloud.sqlite /tmp/
	docker cp $$(docker-compose ps -q jellyphp):/tmp/jellycloud.sqlite backups/jellycloud-$$(date +%Y%m%d-%H%M%S).sqlite
	@echo "✅ Backup salvo em backups/"

db-restore: ## Restaura backup do banco (usar: make db-restore BACKUP=filename)
	@if [ -z "$(BACKUP)" ]; then \
		echo "❌ Especifique o arquivo de backup: make db-restore BACKUP=jellycloud-20250529-123456.sqlite"; \
		exit 1; \
	fi
	@echo "📥 Restaurando backup $(BACKUP)..."
	docker cp backups/$(BACKUP) $$(docker-compose ps -q jellyphp):/tmp/restore.sqlite
	docker-compose exec jellyphp cp /tmp/restore.sqlite /var/www/html/data/jellycloud.sqlite
	@echo "✅ Backup restaurado!"

# Maintenance Commands
clean: ## Remove containers, volumes e imagens
	@echo "🧹 Limpando ambiente..."
	docker-compose down -v --remove-orphans
	docker system prune -f
	docker volume prune -f

clean-all: ## Limpeza completa (cuidado!)
	@echo "⚠️  CUIDADO: Isso removerá TUDO relacionado ao Docker!"
	@read -p "Tem certeza? [y/N] " -n 1 -r; \
	echo; \
	if [[ $$REPLY =~ ^[Yy]$$ ]]; then \
		docker-compose down -v --remove-orphans; \
		docker system prune -a -f --volumes; \
	fi

reset: ## Reset completo (para desenvolvimento)
	@echo "🔄 Reset completo do ambiente..."
	$(MAKE) clean
	$(MAKE) install

# File Management
fix-permissions: ## Corrige permissões dos arquivos
	@echo "🔧 Corrigindo permissões..."
	sudo chown -R $(USER):$(USER) .
	chmod -R 755 src/
	chmod -R 777 storage/ || mkdir -p storage && chmod -R 777 storage/

create-storage: ## Cria diretórios de storage
	@echo "📁 Criando diretórios de storage..."
	mkdir -p storage/{uploads,data,logs}
	chmod -R 777 storage/

# Security Commands
security-scan: ## Executa verificações de segurança
	@echo "🔒 Executando verificações de segurança..."
	@if command -v docker-bench-security >/dev/null 2>&1; then \
		docker-bench-security; \
	else \
		echo "⚠️  docker-bench-security não encontrado"; \
	fi

# Performance Commands
performance-test: ## Testa performance básica
	@echo "⚡ Testando performance..."
	@if command -v ab >/dev/null 2>&1; then \
		ab -n 100 -c 10 http://localhost/; \
	else \
		echo "⚠️  Apache Bench (ab) não encontrado"; \
	fi

# Monitoring Commands
status: ## Mostra status dos containers
	@echo "📊 Status dos containers:"
	docker-compose ps

stats: ## Mostra estatísticas de uso dos containers
	docker stats --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.NetIO}}\t{{.BlockIO}}"

health: ## Verifica saúde da aplicação
	@echo "🏥 Verificando saúde do JellyCloud..."
	@curl -f http://localhost/ >/dev/null 2>&1 && echo "✅ Web OK" || echo "❌ Web ERROR"
	@curl -f http://localhost/api/ >/dev/null 2>&1 && echo "✅ API OK" || echo "❌ API ERROR"

# Development Utilities
watch-logs: ## Monitora logs em tempo real
	docker-compose logs -f --tail=50

tail-error-logs: ## Mostra últimos erros
	docker-compose exec jellyphp tail -f /var/www/html/storage/logs/error.log || echo "Arquivo de erro não encontrado"

debug-mode: ## Ativa modo debug
	@echo "🐛 Ativando modo debug..."
	docker-compose exec jellyphp sed -i 's/"debug":false/"debug":true/' /var/www/html/config.json

production-mode: ## Desativa modo debug
	@echo "🚀 Ativando modo produção..."
	docker-compose exec jellyphp sed -i 's/"debug":true/"debug":false/' /var/www/html/config.json

# Update Commands
update: ## Atualiza para última versão
	@echo "🔄 Atualizando JellyCloud..."
	git pull origin main
	$(MAKE) build
	$(MAKE) restart
	$(MAKE) composer-update

version: ## Mostra versão atual
	@echo "JellyCloud v2.0.0"
	@echo "🍇 Elegant cloud storage inspired by Jellyfin"

# Help with specific commands
help-install: ## Ajuda com instalação
	@echo "📋 Instalação do JellyCloud:"
	@echo "1. Clone o repositório"
	@echo "2. Execute: make install"
	@echo "3. Acesse: http://localhost"
	@echo "4. Login: admin@admin.com / senha: admin"

help-deploy: ## Ajuda com deploy
	@echo "📋 Deploy em Produção:"
	@echo "1. Configure .env para produção"
	@echo "2. Execute: make deploy-prod"
	@echo "3. Configure SSL/HTTPS"
	@echo "4. Configure backup automático"
