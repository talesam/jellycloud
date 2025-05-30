#!/bin/bash

# JellyCloud Quick Setup Script
# Este script automatiza a configuração inicial do JellyCloud

set -e  # Exit on any error

echo "🍇 JellyCloud - Setup Rápido"
echo "============================"
echo ""

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m' # No Color

# Função para log colorido
log() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

success() {
    echo -e "${PURPLE}[SUCCESS]${NC} $1"
}

# Verificar se o Docker está instalado e rodando
check_docker() {
    log "Verificando Docker..."
    
    if ! command -v docker &> /dev/null; then
        error "Docker não está instalado. Por favor, instale o Docker primeiro."
        echo "Visite: https://docs.docker.com/get-docker/"
        exit 1
    fi
    
    if ! docker info &> /dev/null; then
        error "Docker não está rodando. Por favor, inicie o Docker."
        exit 1
    fi
    
    if ! command -v docker-compose &> /dev/null; then
        error "Docker Compose não está instalado."
        echo "Visite: https://docs.docker.com/compose/install/"
        exit 1
    fi
    
    success "Docker OK ✓"
}

# Configurar arquivo .env
setup_env() {
    log "Configurando ambiente..."
    
    if [ ! -f .env ]; then
        cp .env.example .env
        log "Arquivo .env criado a partir do .env.example"
    else
        warn "Arquivo .env já existe, mantendo configurações atuais"
    fi
    
    # Gerar token API aleatório se não existir
    if ! grep -q "API_TOKEN=.*[a-zA-Z0-9]" .env; then
        API_TOKEN=$(openssl rand -hex 32 2>/dev/null || head -c 32 /dev/urandom | base64 | tr -d "=+/" | cut -c1-32)
        sed -i "s/API_TOKEN=.*/API_TOKEN=${API_TOKEN}/" .env
        log "Token API gerado automaticamente"
    fi
    
    success "Ambiente configurado ✓"
}

# Criar diretórios necessários
create_directories() {
    log "Criando diretórios de storage..."
    
    mkdir -p storage/{uploads,data,logs}
    mkdir -p backups
    
    # Definir permissões adequadas
    if [[ "$OSTYPE" != "msys" && "$OSTYPE" != "win32" ]]; then
        chmod -R 755 storage/
        chmod -R 755 backups/
    fi
    
    success "Diretórios criados ✓"
}

# Build e start dos containers
build_and_start() {
    log "Construindo containers Docker..."
    docker-compose build --no-cache
    
    log "Iniciando containers..."
    docker-compose up -d
    
    # Aguardar containers ficarem prontos
    log "Aguardando containers iniciarem..."
    sleep 10
    
    # Verificar se containers estão rodando
    if ! docker-compose ps | grep -q "Up"; then
        error "Falha ao iniciar containers"
        docker-compose logs
        exit 1
    fi
    
    success "Containers iniciados ✓"
}

# Instalar dependências PHP
install_dependencies() {
    log "Instalando dependências do Composer..."
    
    docker-compose exec -T jellyphp composer install --no-dev --optimize-autoloader
    
    if [ $? -eq 0 ]; then
        success "Dependências instaladas ✓"
    else
        warn "Erro ao instalar dependências, tentando novamente..."
        docker-compose exec -T jellyphp composer install
    fi
}

# Verificar se a aplicação está funcionando
health_check() {
    log "Verificando saúde da aplicação..."
    
    # Aguardar um pouco mais para garantir que está tudo pronto
    sleep 5
    
    # Verificar se a página principal carrega
    if curl -f -s http://localhost > /dev/null; then
        success "Aplicação web respondendo ✓"
    else
        warn "Aplicação web não está respondendo ainda..."
        warn "Pode levar alguns segundos para ficar totalmente pronta"
    fi
}

# Mostrar informações finais
show_final_info() {
    echo ""
    echo "🎉 JellyCloud configurado com sucesso!"
    echo "====================================="
    echo ""
    echo "📍 URLs de Acesso:"
    echo "   Web Interface: http://localhost"
    echo "   API Endpoint:  http://localhost/api/"
    echo ""
    echo "👤 Login Padrão:"
    echo "   Email: admin@admin.com"
    echo "   Senha: admin"
    echo ""
    echo "🔧 Comandos Úteis:"
    echo "   Ver logs:      docker-compose logs -f"
    echo "   Parar:         docker-compose down"
    echo "   Reiniciar:     docker-compose restart"
    echo "   Shell PHP:     docker-compose exec jellyphp sh"
    echo ""
    echo "📚 Documentação completa no README.md"
    echo ""
    echo "🍇 Aproveite o JellyCloud!"
}

# Menu interativo para configurações opcionais
optional_setup() {
    echo ""
    echo "⚙️  Configurações Opcionais"
    echo "=========================="
    
    read -p "Deseja popular o banco com dados de teste? [y/N]: " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        log "Populando banco com dados de teste..."
        docker-compose exec -T jellyphp php scripts/populaDb.php
        success "Dados de teste adicionados ✓"
    fi
    
    read -p "Deseja ativar modo debug? [y/N]: " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        log "Ativando modo debug..."
        docker-compose exec -T jellyphp sed -i 's/"debug":false/"debug":true/' /var/www/html/config.json || true
        success "Modo debug ativado ✓"
    fi
}

# Função principal
main() {
    echo "Este script irá configurar o JellyCloud automaticamente."
    echo ""
    
    read -p "Continuar com a instalação? [Y/n]: " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Nn]$ ]]; then
        echo "Instalação cancelada."
        exit 0
    fi
    
    check_docker
    setup_env
    create_directories
    build_and_start
    install_dependencies
    health_check
    optional_setup
    show_final_info
}

# Tratar interrupções
trap 'echo ""; error "Setup interrompido pelo usuário"; exit 1' INT

# Executar setup
main "$@"
