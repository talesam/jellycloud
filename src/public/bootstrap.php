<?php
// Configurações básicas
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('America/Sao_Paulo');
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Strict');
session_start();

// Configurações de segurança
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Configuração de cache
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

// Inclui arquivos necessários
require_once DIR_ROOT . "/Includes/Functions.php";
require_once DIR_ROOT . "/Config/Definitions.php";
require_once DIR_ROOT . '/vendor/autoload.php';

// Carrega as variáveis de ambiente do arquivo .env
use JellyCloud\Includes\Env;
Env::load( [ '.env', '.env.local' ] );

// Gera token CSRF se não existir
if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
    $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
}

// Verifica se é uma requisição para a API
if (strpos($uri, "/api/") !== false) {
    require_once DIR_ROOT . "/Api/index.php";
    exit;
}

// Verifica se o usuário está logado
require_once DIR_ROOT . "/Includes/CheckSession.php";

// Registra o handler de erros
set_error_handler('handleError');
