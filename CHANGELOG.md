# JellyCloud Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado no [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2025-05-29

### 🎉 Major Release - Transformação para JellyCloud

Esta é uma versão major que transforma completamente o CloudMoura em JellyCloud, com novo design, branding e experiência do usuário.

### ✨ Adicionado

#### 🎨 Nova Identidade Visual
- **Logo JellyCloud**: Novo logotipo SVG com gradientes inspirados no Jellyfin
- **Favicon**: Ícone compacto para browser tabs
- **Paleta de Cores**: Sistema baseado no Jellyfin (#AA5CC3, #6A4C93, #7D4698)
- **Design System**: Variáveis CSS organizadas para consistência

#### 🖥️ Interface Completamente Redesenhada
- **Estilo macOS**: Cards com bordas arredondadas e sombras suaves
- **Gradientes Jellyfin**: Botões e headers com gradientes elegantes
- **Componentes Modernos**: Forms com floating labels, toggles switches, badges
- **Animações Suaves**: Transições e hover effects em toda a interface
- **Responsividade Melhorada**: Layout adaptável para todos os dispositivos

#### 📱 Páginas Transformadas
- **Login/Registro**: Cards centralizados com novo layout auth
- **Dashboard Admin**: Header com gradiente e sidebar elegante
- **Gerenciador de Arquivos**: Interface moderna com drag-and-drop melhorado
- **Gestão de Usuários**: Tabela com avatars, badges de status e dropdowns
- **Configurações**: Interface com toggle switches e cards organizados
- **Perfil de Usuário**: Header com avatar grande e formulários estilizados
- **Páginas de Erro**: Design consistente com branding JellyCloud
- **Manutenção**: Interface moderna com spinners e indicadores de progresso

#### 🔧 Melhorias Técnicas
- **CSS Variables**: Sistema completo de design tokens
- **Componentes Reutilizáveis**: Classes CSS organizadas (.card-macos, .btn-jellyfin, etc.)
- **JavaScript Aprimorado**: Melhor UX com loading states e validações
- **Docker Atualizado**: Containers renomeados e configurações otimizadas
- **Scripts Melhorados**: Build e deploy com emoji e mensagens informativas

### 🔄 Mudado

#### 🏷️ Rebranding Completo
- **CloudMoura** → **JellyCloud** em toda a aplicação
- **Banco de Dados**: `cloudmoura.sqlite` → `jellycloud.sqlite`
- **Containers Docker**: `cloudmoura-php` → `jellyphp`
- **Redes Docker**: `cloudstore-net` → `jellycloud-net`
- **Metadados**: composer.json, LICENSE e documentação atualizados

#### 🎯 Experiência do Usuário
- **Fluxos de Autenticação**: Layout consistente em todas as páginas auth
- **Feedback Visual**: Alertas coloridos e estados de loading melhorados
- **Navegação**: Breadcrumbs e menus mais intuitivos
- **Formulários**: Validação visual e toggles de senha modernos
- **Tabelas**: Design mais limpo com paginação elegante

#### 📊 Interface Administrativa
- **Dashboard**: Estatísticas visuais e cards informativos
- **Gestão**: Interfaces mais intuitivas para usuários e arquivos
- **Configurações**: Organização em cards com controles visuais
- **Relatórios**: Apresentação mais clara de dados e logs

### 🛠️ Correções
- **Consistência Visual**: Alinhamento de elementos em todas as páginas
- **Responsividade**: Quebras de layout em dispositivos móveis
- **Acessibilidade**: Contraste e navegação por teclado melhorados
- **Performance**: Otimização de CSS e JavaScript
- **Segurança**: Validações e sanitização aprimoradas

### 📚 Documentação
- **README.md**: Documentação completa atualizada
- **Guia de Estilo**: Documentação do design system
- **API**: Endpoints documentados com exemplos
- **Deploy**: Instruções detalhadas para produção
- **Contribuição**: Guias para desenvolvedores

### 🔧 Configurações Docker
- **docker-compose.yml**: Nomes e redes atualizados
- **nginx.conf**: Referências corrigidas para containers
- **PHP Dockerfile**: Configurações otimizadas
- **Scripts**: Build e deploy com branding JellyCloud

---

## [1.x.x] - CloudMoura Legacy

As versões anteriores mantinham o branding CloudMoura e interface básica.

### Funcionalidades Mantidas
- ✅ Sistema de autenticação completo
- ✅ Gerenciamento de arquivos
- ✅ API RESTful
- ✅ Painel administrativo
- ✅ Docker containerization
- ✅ Segurança (CSRF, sessões)

---

## 🚀 Próximas Versões

### Planejado para v2.1.0
- [ ] Dashboard com gráficos interativos
- [ ] Sistema de notificações em tempo real
- [ ] Preview de arquivos integrado
- [ ] Temas personalizáveis
- [ ] API v2 com GraphQL

### Planejado para v2.2.0
- [ ] Compartilhamento de arquivos público
- [ ] Integração com serviços de nuvem externos
- [ ] Sistema de comentários em arquivos
- [ ] Versionamento de arquivos
- [ ] Backup automático

---

## 🤝 Contribuindo

Encontrou um bug ou tem uma sugestão? 
1. Abra uma issue
2. Faça um fork do projeto
3. Crie uma branch para sua feature
4. Envie um pull request

## 📝 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

---

**JellyCloud** - *Elegant cloud storage inspired by Jellyfin* 🍇
