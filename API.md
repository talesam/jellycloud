# 🍇 JellyCloud API Documentation

A API do JellyCloud oferece endpoints RESTful para integração com aplicações externas. Todos os endpoints retornam dados em formato JSON.

## 📋 Sumário

- [Autenticação](#autenticação)
- [Endpoints de Usuários](#endpoints-de-usuários)
- [Endpoints de Arquivos](#endpoints-de-arquivos)
- [Endpoints de Configuração](#endpoints-de-configuração)
- [Códigos de Status](#códigos-de-status)
- [Exemplos de Uso](#exemplos-de-uso)

## 🔐 Autenticação

A API utiliza autenticação baseada em sessão. Para acessar endpoints protegidos, você deve estar logado.

### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "admin@admin.com",
  "password": "admin"
}
```

**Resposta de Sucesso:**
```json
{
  "success": true,
  "message": "Login realizado com sucesso",
  "data": {
    "user": {
      "id": 1,
      "name": "Administrador",
      "email": "admin@admin.com",
      "role": "admin"
    }
  }
}
```

### Logout
```http
POST /api/logout
```

## 👥 Endpoints de Usuários

### Listar Usuários
```http
GET /api/users
```

**Resposta:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Administrador",
      "email": "admin@admin.com",
      "role": "admin",
      "status": "active",
      "created_at": "2025-05-29T10:00:00Z"
    }
  ]
}
```

### Criar Usuário
```http
POST /api/users
Content-Type: application/json

{
  "name": "Novo Usuário",
  "email": "usuario@exemplo.com",
  "password": "senhaSegura123",
  "role": "user"
}
```

### Atualizar Usuário
```http
PUT /api/users/{id}
Content-Type: application/json

{
  "name": "Nome Atualizado",
  "email": "novo@email.com",
  "role": "admin"
}
```

### Deletar Usuário
```http
DELETE /api/users/{id}
```

### Buscar Usuários
```http
GET /api/users/search?q=termo&limit=10&offset=0
```

## 📁 Endpoints de Arquivos

### Listar Arquivos
```http
GET /api/files?path=/caminho/opcional
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "current_path": "/",
    "files": [
      {
        "name": "documento.pdf",
        "type": "file",
        "size": 1024000,
        "modified": "2025-05-29T10:00:00Z",
        "path": "/documento.pdf"
      },
      {
        "name": "pasta",
        "type": "directory",
        "modified": "2025-05-29T09:00:00Z",
        "path": "/pasta"
      }
    ]
  }
}
```

### Upload de Arquivo
```http
POST /api/files/upload
Content-Type: multipart/form-data

{
  "file": [arquivo],
  "path": "/destino/opcional"
}
```

### Download de Arquivo
```http
GET /api/files/download?path=/caminho/para/arquivo.pdf
```

### Criar Diretório
```http
POST /api/files/createDir
Content-Type: application/json

{
  "path": "/novo/diretorio",
  "name": "NomeDoDiretorio"
}
```

### Deletar Arquivo/Diretório
```http
DELETE /api/files/delete
Content-Type: application/json

{
  "path": "/caminho/para/item"
}
```

### Mover/Renomear
```http
POST /api/files/move
Content-Type: application/json

{
  "source": "/caminho/origem",
  "destination": "/caminho/destino"
}
```

### Informações do Arquivo
```http
GET /api/files/info?path=/caminho/para/arquivo
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "name": "arquivo.pdf",
    "size": 1024000,
    "type": "application/pdf",
    "modified": "2025-05-29T10:00:00Z",
    "permissions": "rwxr--r--",
    "path": "/arquivo.pdf"
  }
}
```

## ⚙️ Endpoints de Configuração

### Toggle Debug Mode
```http
POST /api/configurations/toggledebug
```

### Toggle Site Block
```http
POST /api/configurations/toggleblocksite
```

### Obter Configurações
```http
GET /api/configurations
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "debug": true,
    "block": false,
    "version": "2.0.0",
    "features": {
      "upload_enabled": true,
      "max_upload_size": "5G",
      "allowed_extensions": ["jpg", "png", "pdf", "txt"]
    }
  }
}
```

## 📊 Status e Saúde

### Health Check
```http
GET /api/health
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "status": "healthy",
    "version": "2.0.0",
    "uptime": 3600,
    "database": "connected",
    "storage": "available"
  }
}
```

### Estatísticas do Sistema
```http
GET /api/stats
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "users": {
      "total": 150,
      "active": 142,
      "admins": 3
    },
    "files": {
      "total": 1205,
      "total_size": "2.5GB",
      "directories": 85
    },
    "storage": {
      "used": "2.5GB",
      "available": "47.5GB",
      "percentage": 5
    }
  }
}
```

## 📋 Códigos de Status HTTP

| Código | Significado |
|--------|-------------|
| 200 | OK - Requisição bem-sucedida |
| 201 | Created - Recurso criado com sucesso |
| 400 | Bad Request - Dados inválidos |
| 401 | Unauthorized - Autenticação necessária |
| 403 | Forbidden - Sem permissão |
| 404 | Not Found - Recurso não encontrado |
| 422 | Unprocessable Entity - Dados de entrada inválidos |
| 500 | Internal Server Error - Erro do servidor |

## 🔒 Segurança

### Rate Limiting
- **Login**: 5 tentativas por minuto por IP
- **API Geral**: 30 requisições por minuto por IP
- **Upload**: 10 uploads por minuto por usuário

### Headers de Segurança
```http
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
X-XSS-Protection: 1; mode=block
Content-Security-Policy: default-src 'self'
```

### CSRF Protection
Todas as requisições POST/PUT/DELETE devem incluir o token CSRF no header ou formulário.

## 📝 Exemplos de Uso

### JavaScript (Fetch API)
```javascript
// Login
const login = async (email, password) => {
  const response = await fetch('/api/login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ email, password })
  });
  return await response.json();
};

// Upload de arquivo
const uploadFile = async (file, path = '/') => {
  const formData = new FormData();
  formData.append('file', file);
  formData.append('path', path);
  
  const response = await fetch('/api/files/upload', {
    method: 'POST',
    body: formData
  });
  return await response.json();
};

// Listar arquivos
const listFiles = async (path = '/') => {
  const response = await fetch(`/api/files?path=${encodeURIComponent(path)}`);
  return await response.json();
};
```

### PHP (cURL)
```php
// Login
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'http://localhost/api/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => json_encode([
        'email' => 'admin@admin.com',
        'password' => 'admin'
    ])
]);
$response = curl_exec($curl);
curl_close($curl);
```

### Python (requests)
```python
import requests

# Login
response = requests.post('http://localhost/api/login', json={
    'email': 'admin@admin.com',
    'password': 'admin'
})
data = response.json()

# Upload de arquivo
files = {'file': open('documento.pdf', 'rb')}
response = requests.post('http://localhost/api/files/upload', files=files)
```

### cURL (Terminal)
```bash
# Login
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@admin.com","password":"admin"}'

# Upload de arquivo
curl -X POST http://localhost/api/files/upload \
  -F "file=@documento.pdf" \
  -F "path=/"

# Listar arquivos
curl http://localhost/api/files?path=/

# Download de arquivo
curl -o arquivo.pdf "http://localhost/api/files/download?path=/arquivo.pdf"
```

## 🐛 Tratamento de Erros

### Formato de Erro Padrão
```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Os dados fornecidos são inválidos",
    "details": {
      "email": ["O campo email é obrigatório"],
      "password": ["A senha deve ter pelo menos 6 caracteres"]
    }
  }
}
```

### Códigos de Erro Comuns
- `VALIDATION_ERROR` - Dados de entrada inválidos
- `AUTHENTICATION_FAILED` - Falha na autenticação
- `PERMISSION_DENIED` - Sem permissão para a ação
- `RESOURCE_NOT_FOUND` - Recurso não encontrado
- `FILE_TOO_LARGE` - Arquivo muito grande
- `INVALID_FILE_TYPE` - Tipo de arquivo não permitido
- `STORAGE_FULL` - Espaço em disco insuficiente

## 🔄 Versionamento

A API segue versionamento semântico:
- **v2.0.0** - Versão atual com design JellyCloud
- **v1.x.x** - Versões legacy (CloudMoura)

### Headers de Versão
```http
Accept: application/json
X-API-Version: 2.0
```

## 📚 SDKs e Bibliotecas

Planejamos criar SDKs oficiais para:
- [ ] JavaScript/TypeScript
- [ ] PHP
- [ ] Python
- [ ] Go

## 🤝 Contribuindo

Encontrou um bug na API ou tem uma sugestão?
1. Abra uma issue no GitHub
2. Descreva o endpoint afetado
3. Inclua exemplo de requisição/resposta
4. Mencione a versão da API

---

**JellyCloud API v2.0** - *Elegant cloud storage API* 🍇
