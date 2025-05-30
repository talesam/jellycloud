# 🍇 Contribuindo para o JellyCloud

Obrigado pelo seu interesse em contribuir para o JellyCloud! Este documento fornece diretrizes para contribuir com o projeto.

## 📋 Sumário

- [Como Contribuir](#como-contribuir)
- [Configuração do Ambiente](#configuração-do-ambiente)
- [Padrões de Código](#padrões-de-código)
- [Processo de Pull Request](#processo-de-pull-request)
- [Reportando Bugs](#reportando-bugs)
- [Sugerindo Features](#sugerindo-features)
- [Guia de Estilo](#guia-de-estilo)

## 🤝 Como Contribuir

### Tipos de Contribuição
- 🐛 **Bug fixes** - Correção de problemas existentes
- ✨ **Features** - Novas funcionalidades
- 📚 **Documentação** - Melhorias na documentação
- 🎨 **UI/UX** - Melhorias visuais e de experiência
- ⚡ **Performance** - Otimizações de performance
- 🧪 **Testes** - Adição ou melhoria de testes

### Processo Geral
1. Fork o repositório
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`)
3. Faça commit das suas mudanças (`git commit -am 'Adiciona nova feature'`)
4. Push para a branch (`git push origin feature/nova-feature`)
5. Abra um Pull Request

## 🛠️ Configuração do Ambiente

### Pré-requisitos
- Docker & Docker Compose
- Git
- Editor de código (recomendamos VS Code)

### Setup Local
```bash
# Clone o repositório
git clone https://github.com/jellycp/jellycloud.git
cd jellycloud

# Copie o arquivo de ambiente
cp .env.example .env

# Suba os containers
docker-compose up -d

# Acesse a aplicação
open http://localhost
```

### Estrutura do Projeto
```
src/
├── public/         # Assets públicos (CSS, JS, imagens)
├── Pages/          # Views e páginas
├── Api/            # Endpoints da API
├── Config/         # Configurações
├── Includes/       # Classes utilitárias
└── storage/        # Armazenamento (uploads, dados, logs)
```

## 📝 Padrões de Código

### PHP
- Use **PSR-12** para style coding
- Nomes de classes em **PascalCase**
- Nomes de métodos e variáveis em **camelCase**
- Constantes em **UPPER_CASE**
- Sempre use type hints quando possível

```php
<?php

namespace JellyCloud\\Controllers;

class ExampleController
{
    public function processData(array $data): array
    {
        // código aqui
    }
}
```

### CSS
- Use **variáveis CSS** para cores e medidas
- Siga a nomenclatura **BEM** para classes CSS
- Mantenha consistência com o design system JellyCloud

```css
/* ✅ Bom */
.btn-jellyfin {
    background: var(--jellyfin-gradient);
    border-radius: var(--border-radius-md);
}

.card-macos__header {
    padding: var(--spacing-md);
}
```

### JavaScript
- Use **ES6+** syntax
- Nomes de variáveis e funções em **camelCase**
- Use `const` e `let`, evite `var`
- Adicione comentários para lógica complexa

```javascript
// ✅ Bom
const handleFileUpload = async (files) => {
    try {
        const formData = new FormData();
        // lógica aqui
    } catch (error) {
        console.error('Erro no upload:', error);
    }
};
```

## 🔄 Processo de Pull Request

### Antes de Submeter
- [ ] Teste localmente
- [ ] Execute verificações de código
- [ ] Atualize documentação se necessário
- [ ] Adicione/atualize testes se aplicável

### Template do PR
```markdown
## 📋 Descrição
Breve descrição das mudanças realizadas.

## 🔧 Tipo de Mudança
- [ ] Bug fix (mudança que corrige um problema)
- [ ] Nova feature (mudança que adiciona funcionalidade)
- [ ] Breaking change (mudança que quebra compatibilidade)
- [ ] Documentação

## 🧪 Como Testar
Passos para testar as mudanças:
1. 
2. 
3. 

## 📸 Screenshots
Se aplicável, adicione screenshots das mudanças visuais.

## ✅ Checklist
- [ ] Meu código segue os padrões do projeto
- [ ] Revisei meu próprio código
- [ ] Comentei código complexo
- [ ] Atualizei a documentação
- [ ] Minhas mudanças não geram warnings
- [ ] Testei localmente
```

## 🐛 Reportando Bugs

### Template de Bug Report
```markdown
## 🐛 Descrição do Bug
Descrição clara e concisa do problema.

## 🔄 Passos para Reproduzir
1. Vá para '...'
2. Clique em '....'
3. Role para baixo até '....'
4. Veja o erro

## ✅ Comportamento Esperado
Descrição clara do que deveria acontecer.

## 📸 Screenshots
Se aplicável, adicione screenshots do problema.

## 🖥️ Ambiente
- OS: [ex: Windows 10, macOS 12, Ubuntu 20.04]
- Browser: [ex: Chrome 96, Firefox 95, Safari 15]
- Versão do JellyCloud: [ex: 2.0.0]
- Docker version: [ex: 20.10.12]

## ℹ️ Informações Adicionais
Qualquer contexto adicional sobre o problema.
```

## ✨ Sugerindo Features

### Template de Feature Request
```markdown
## 🚀 Feature Request

### 📋 Descrição
Descrição clara da feature desejada.

### 🤔 Problema que Resolve
Qual problema esta feature resolveria?

### 💡 Solução Proposta
Descrição clara de como você gostaria que funcionasse.

### 🔄 Alternativas Consideradas
Outras soluções que você considerou.

### ✅ Benefícios
- Benefício 1
- Benefício 2
- Benefício 3

### 📸 Mockups/Wireframes
Se aplicável, adicione designs ou wireframes.
```

## 🎨 Guia de Estilo

### Design System JellyCloud

#### Cores
```css
/* Jellyfin Palette */
--jellyfin-primary: #AA5CC3;
--jellyfin-secondary: #6A4C93;
--jellyfin-accent: #7D4698;

/* macOS Inspired */
--macos-bg: #f5f5f7;
--macos-surface: #ffffff;
--macos-overlay: rgba(255, 255, 255, 0.8);
```

#### Componentes
- Use `.card-macos` para cards
- Use `.btn-jellyfin` para botões primários
- Use `.alert-*-jellyfin` para alertas
- Mantenha consistência com gradientes e sombras

### Ícones
- Use Font Awesome 6
- Prefira ícones solid para ações principais
- Use ícones regular para secundários

### Tipografia
- Headers: Inter font family
- Body: System fonts (-apple-system, BlinkMacSystemFont)
- Code: Menlo, Monaco, monospace

## 🧪 Testes

### Executando Testes
```bash
# PHP Tests (se implementados)
docker-compose exec jellyphp ./vendor/bin/phpunit

# Frontend Tests (se implementados)
npm test

# Testes de Integração
docker-compose exec jellycloud curl -f http://localhost/api/health
```

### Adicionando Testes
- Testes unitários para lógica de negócio
- Testes de integração para API
- Testes E2E para fluxos críticos

## 📚 Recursos Úteis

- [Documentação do PHP](https://www.php.net/docs.php)
- [Docker Documentation](https://docs.docker.com/)
- [Jellyfin Design](https://jellyfin.org/) - Inspiração visual
- [macOS Human Interface Guidelines](https://developer.apple.com/design/human-interface-guidelines/macos/overview/themes/)

## 🤔 Dúvidas?

- Abra uma **issue** para discussões gerais
- Use **discussions** para perguntas sobre desenvolvimento
- Entre em contato via email: admin@jellycloud.com

## 📄 Licença

Ao contribuir, você concorda que suas contribuições serão licenciadas sob a **Licença MIT**.

---

**Obrigado por contribuir com o JellyCloud!** 🍇✨
