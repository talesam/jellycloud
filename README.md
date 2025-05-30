# JellyCloud

Uma aplicação web moderna para gerenciamento de arquivos na nuvem, desenvolvida em PHP com Docker. Apresenta design elegante inspirado no Jellyfin e na interface do macOS.

## ✨ Características

- **Design Moderno**: Interface inspirada no Jellyfin com paleta de cores roxa e elementos do macOS
- **Responsivo**: Totalmente adaptável para desktop, tablet e mobile
- **Gerenciamento de Arquivos**: Upload, download, organização e compartilhamento
- **Sistema de Usuários**: Autenticação, perfis e permissões
- **API RESTful**: Endpoints organizados e documentados
- **Segurança**: CSRF protection, rate limiting e validação de sessão

## 🎨 Design System

### Paleta de Cores
- **Primária**: `#AA5CC3` (Jellyfin Purple)
- **Secundária**: `#6A4C93` (Deep Purple)
- **Accent**: `#7D4698` (Medium Purple)
- **Superfícies**: Tons de cinza inspirados no macOS

### Componentes
- Cards com estilo macOS (bordas arredondadas, sombras suaves)
- Botões com gradientes Jellyfin
- Formulários com floating labels
- Alertas coloridos contextual
- Spinners e animações suaves

## 📁 Estrutura do Projeto

```
src/
├── public/              # Arquivos públicos e assets
│   ├── css/
│   │   ├── bootstrap.min.css
│   │   ├── general.css      # Design system JellyCloud
│   │   └── drag-drop.css
│   ├── js/
│   │   ├── general.js       # Funções globais
│   │   ├── files.js         # Gerenciamento de arquivos
│   │   └── drag-drop.js     # Drag & drop
│   ├── img/
│   │   ├── jellycloud-logo.svg     # Logo principal
│   │   └── favicon/
│   │       └── jellycloud-icon.svg # Favicon
│   ├── bootstrap.php        # Inicialização
│   └── index.php           # Front Controller
├── Pages/              # Páginas da aplicação
│   ├── admin/          # Painel administrativo
│   │   ├── index.php       # Dashboard
│   │   ├── files.php       # Gerenciador de arquivos
│   │   ├── usuarios.php    # Gestão de usuários
│   │   ├── configuracoes.php # Configurações
│   │   └── conta.php       # Perfil do usuário
│   ├── auth/           # Autenticação
│   │   ├── login/
│   │   ├── cadastrar/
│   │   ├── ativar/
│   │   ├── recuperar_senha/
│   │   └── trocar_senha/
│   ├── utility/        # Páginas utilitárias
│   │   ├── page_error/     # Página de erro 404
│   │   ├── site_manutencao/ # Página de manutenção
│   │   └── desbloquear/    # Desbloqueio do sistema
│   └── helper/
│       └── View.php        # Helper para geração de views
├── Api/               # Endpoints da API
│   ├── Controllers/
│   │   ├── UserController.php
│   │   ├── FilesController.php
│   │   ├── LoginController.php
│   │   └── ConfigurationsController.php
│   ├── bootstrap.php      # Inicialização da API
│   └── index.php         # Roteador da API
├── Config/            # Configurações
│   ├── Definitions.php    # Constantes e configurações
│   ├── Database.php
│   └── Mail.php
├── Includes/          # Classes utilitárias
│   ├── Functions.php      # Funções globais
│   ├── CheckSession.php   # Verificação de sessão
│   ├── Db.php            # Conexão com banco
│   ├── Response.php      # Padronização de respostas
│   └── Logs.php          # Sistema de logs
└── vendor/           # Dependências (via Composer)

docker/               # Configurações do Docker
├── nginx/
│   └── nginx.conf
└── php/
    ├── Dockerfile
    ├── entrypoint.sh
    └── php.ini
```

## 🔄 Fluxo das Requisições

1. **Front Controller**: Todas as requisições entram por `src/public/index.php`
2. **Bootstrap**: O `bootstrap.php` é carregado e inicializa:
   - Funções utilitárias (`Functions.php`)
   - Definições globais (`Definitions.php`)
   - Autoloader do Composer
   - Variáveis de ambiente (.env)
   - Roteamento da API
   - Verificação de sessão (`CheckSession.php`)
   - Tokens CSRF
3. **Roteamento**: Com base na URI, o conteúdo apropriado é carregado de `src/Pages/`
4. **Renderização**: Views são renderizadas com o design system JellyCloud

## 🚀 Ambiente de Desenvolvimento

### Pré-requisitos
- Docker
- Docker Compose

### Instalação

1. **Clone o repositório**:
```bash
git clone https://github.com/jellycp/jellycloud.git
cd jellycloud
```

2. **Configure as variáveis de ambiente**:
```bash
cp .env.example .env
# Edite o arquivo .env com suas configurações
```

3. **Suba os containers**:
```bash
docker-compose up -d
```

4. **Acesse a aplicação**:
- Interface: `http://localhost:8080`
- API: `http://localhost:8080/api/`

## 🎯 Funcionalidades

### 👤 Gestão de Usuários
- ✅ Registro e ativação por e-mail
- ✅ Login/logout com sessão segura
- ✅ Recuperação de senha
- ✅ Perfis de usuário (admin/user)
- ✅ Gestão de usuários (admin)

### 📁 Gerenciamento de Arquivos
- ✅ Upload de arquivos (drag & drop)
- ✅ Navegação por diretórios
- ✅ Criação de pastas
- ✅ Download de arquivos
- ✅ Exclusão com confirmação
- ✅ Visualização de detalhes

### ⚙️ Sistema
- ✅ Configurações dinâmicas
- ✅ Modo debug
- ✅ Bloqueio de sistema
- ✅ Logs detalhados
- ✅ Rate limiting
- ✅ Proteção CSRF

## 🎨 Guia de Estilo

### CSS Classes Principais

#### Layout
- `.auth-container` - Container para páginas de autenticação
- `.auth-card` - Card principal das páginas auth
- `.card-macos` - Cards com estilo macOS
- `.card-header-jellyfin` - Headers com gradiente Jellyfin

#### Botões
- `.btn-jellyfin` - Botão primário com gradiente
- `.btn-jellyfin-outline` - Botão outline estilizado
- `.btn-macos` - Botão com estilo macOS

#### Formulários
- `.form-control-macos` - Input com estilo macOS
- `.form-group-jellyfin` - Grupo de formulário estilizado
- `.input-group-jellyfin` - Input com ícones

#### Alertas
- `.alert-info-jellyfin` - Alerta informativo
- `.alert-warning-jellyfin` - Alerta de aviso
- `.alert-danger-jellyfin` - Alerta de erro
- `.alert-success-jellyfin` - Alerta de sucesso

### Variáveis CSS
```css
:root {
  /* Jellyfin Colors */
  --jellyfin-primary: #AA5CC3;
  --jellyfin-secondary: #6A4C93;
  --jellyfin-accent: #7D4698;
  
  /* macOS Colors */
  --macos-bg: #f5f5f7;
  --macos-surface: #ffffff;
  --macos-text-primary: #1d1d1f;
  --macos-text-secondary: #6e6e73;
  
  /* Shadows */
  --macos-shadow-light: 0 1px 3px rgba(0, 0, 0, 0.1);
  --macos-shadow-medium: 0 4px 20px rgba(0, 0, 0, 0.15);
  --macos-shadow-heavy: 0 8px 30px rgba(170, 92, 195, 0.2);
}
```
   - Definições globais (`Definitions.php`)
   - Autoloader do Composer
   - Variáveis de ambiente
   - API handlers
   - Verificação de sessão (`CheckSession.php`)
3. Com base na URI, o conteúdo apropriado é carregado de `src/pages/`

## Ambiente de Desenvolvimento

### Pré-requisitos
- Docker
- Docker Compose

### Configuração
1. Clone o repositório
2. Execute `docker-compose up -d`
3. Instale as dependências: `docker-compose run composer install`
4. Você executar o script `src/scripts/build.sh`

### Containers
- PHP 8.1 (FPM) (jellyphp)
- Nginx (jellycloud)
- Composer (jellycloud-composer)

## Rede
O projeto utiliza a rede `jellycloud-net` para integração com outros serviços.

## 🚀 Características

- Sistema de autenticação seguro
- Gerenciamento de usuários
- Interface moderna e responsiva
- API RESTful
- Banco de dados SQLite
- Sistema de logs para debug
- Página de manutenção
- Sistema de roles (admin/user)

## 📋 Pré-requisitos

- PHP 8.0 ou superior
- SQLite3
- Nginx
- Composer (para gerenciamento de dependências)

## 🔧 Instalação

1. Clone o repositório:
```bash
git clone https://github.com/jellycp/jellycloud.git
```
```bash
cd jellycloud
```

2. Docker
```bash
cp docker-compose-default.yml docker-compose.yml
```
```bash
docker-compose up -d
```

3. Acesse o sistema através do navegador:
```
http://localhost:8080/
```

4. Na primeira vez que acessar, faça o login com as credenciais padrão (admin@admin.com / Admin01). O sistema irá automaticamente:
   - Criar o banco de dados SQLite
   - Criar as tabelas necessárias
   - Configurar o primeiro usuário administrador

## 📁 Estrutura do Projeto

```
src/
├── api/             # Endpoints da API REST
├── config/          # Arquivos de configuração
├── data/            # Diretório para dados do SQLite
├── includes/        # Classes e funções auxiliares
├── logs/            # Diretório de logs
├── public/          # Arquivos públicos e ponto de entrada
├── scripts/         # Scripts utilitários
└── uploads/         # Diretório para guardar seus arquivos
```

## 🔐 Credenciais Padrão

- **Email**: admin@admin.com
- **Senha**: Admin01

## 🛠️ Tecnologias Utilizadas

- PHP 8.0+
- SQLite3
- HTML5
- CSS3
- JavaScript
- Bootstrap 5

## 📝 Logs

O sistema mantém logs detalhados para debug e monitoramento. Os logs são armazenados em:
```
src/logs/
```

## 📤 Uploads
O sistema mantém seus arquivos pessoais em:
```
src/uploads/
```

## 🔒 Segurança

- Senhas armazenadas com hash seguro
- Proteção contra SQL Injection
- Validação de entrada de dados
- Sistema de roles para controle de acesso
- Página de manutenção para downtime planejado

## 📡 API Endpoints

### Autenticação
- `POST /api/login/login` - Login de usuário
- `POST /api/user/create` - Registro de usuário
- `POST /api/user/activateByCode` - Ativação por código
- `POST /api/user/recoverPassword` - Recuperação de senha
- `POST /api/user/resetPassword` - Reset de senha

### Gestão de Usuários
- `POST /api/user/getList` - Listar usuários (admin)
- `POST /api/user/update` - Atualizar perfil
- `POST /api/user/activate` - Ativar/desativar usuário (admin)
- `POST /api/user/delete` - Excluir usuário (admin)

### Arquivos
- `POST /api/files/upload` - Upload de arquivo
- `POST /api/files/list` - Listar arquivos/diretórios
- `POST /api/files/createDir` - Criar diretório
- `DELETE /api/files/delete` - Excluir arquivo/diretório
- `GET /api/files/download` - Download de arquivo

### Configurações
- `POST /api/configurations/toggledebug` - Toggle modo debug
- `POST /api/configurations/toggleblocksite` - Toggle bloqueio do site

## 🔧 Configuração

### Variáveis de Ambiente (.env)
```bash
# Database
DB_HOST=database
DB_NAME=jellycloud
DB_USER=root
DB_PASS=password

# Mail (SMTP)
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USER=your@email.com
MAIL_PASS=your-app-password
MAIL_FROM=your@email.com
MAIL_FROM_NAME="JellyCloud"

# Application
APP_URL=http://localhost:8080
APP_NAME="JellyCloud"
ALLOWED_EXTENSIONS=["jpg","jpeg","png","gif","pdf","txt","doc","docx","zip"]
```

### Configurações do Sistema (config.json)
```json
{
  "block": false,    // Bloqueia acesso de usuários comuns
  "debug": true      // Ativa modo debug
}
```

## 🚀 Deployment

### Docker (Produção)
```bash
# Build das imagens
docker-compose -f docker-compose.prod.yml build

# Deploy
docker-compose -f docker-compose.prod.yml up -d

# Logs
docker-compose logs -f
```

### Configurações de Produção
1. **Desative o modo debug** no `config.json`
2. **Configure HTTPS** no nginx
3. **Use senhas seguras** no banco de dados
4. **Configure backup** dos arquivos e banco
5. **Monitore os logs** regularmente

## 🤝 Contribuição

1. Fork o projeto
2. Crie sua feature branch (`git checkout -b feature/nova-funcionalidade`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova funcionalidade'`)
4. Push para a branch (`git push origin feature/nova-funcionalidade`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 📞 Suporte

- **Issues**: Abra uma issue no GitHub
- **Documentação**: Consulte este README
- **Email**: Entre em contato através do e-mail configurado

---

## 🎨 Créditos de Design

- **Inspiração Visual**: [Jellyfin](https://jellyfin.org/) - Paleta de cores e elementos visuais
- **Sistema de Design**: Apple macOS - Componentes e padrões de interface
- **Ícones**: Font Awesome 6
- **Tipografia**: San Francisco (macOS) / System fonts

## 📈 Changelog

### v2.0.0 - JellyCloud Redesign
- ✨ Novo design system inspirado no Jellyfin
- 🎨 Interface completamente redesenhada com elementos macOS
- 🌈 Nova paleta de cores roxa
- 📱 Melhor responsividade mobile
- 🚀 Performance aprimorada
- 🔒 Segurança reforçada

### v1.0.0 - CloudMoura Original
- 📁 Sistema básico de gerenciamento de arquivos
- 👤 Sistema de usuários
- 🔐 Autenticação segura
- 📊 Painel administrativo

---

<div align="center">
  <img src="src/public/img/jellycloud-logo.svg" alt="JellyCloud" width="200">
  
  **Feito com ❤️ para a nuvem**
</div>