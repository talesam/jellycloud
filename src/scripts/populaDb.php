<?php
/**
 * JellyCloud Database Population Script
 * 
 * Script para popular o banco de dados do JellyCloud com dados de teste
 * Usado principalmente para desenvolvimento e testes de performance
 */

define('DIR_ROOT', dirname(__DIR__));

// Carrega as configurações
$config = json_decode( file_get_contents( DIR_ROOT . '/config.json'), true);

// Carrega o autoloader
require_once DIR_ROOT . '/includes/Functions.php';
require_once DIR_ROOT . '/config/Definitions.php';
require_once DIR_ROOT . '/config/Autoload.php';

$Db = new \JellyCloud\Includes\Db();

try {
    echo "🍇 JellyCloud - Script de População do Banco\n";
    echo "==========================================\n\n";
    
    // Limpa registros com ID maior que 10
    echo "🧹 Limpando registros antigos...\n";
    $Db->query("DELETE FROM users WHERE id > 1");
    if ($Db->getLastError()) {
        throw new \Exception($Db->getLastError());
    }
    echo "✅ Registros antigos removidos com sucesso.\n\n";

    $total = 10000;
    $batch = 1000; // Número de registros por lote
    $lotes = ceil($total / $batch);

    echo "📊 Iniciando inserção de {$total} usuários...\n";

    for ($lote = 0; $lote < $lotes; $lote++) {
        $inicio = $lote * $batch;
        $fim = min(($lote + 1) * $batch, $total);
        
        echo "⏳ Processando lote " . ($lote + 1) . " de {$lotes} (registros {$inicio} a {$fim})...\n";

        for ($i = $inicio; $i < $fim; $i++) {
            $numero = str_pad($i, 5, '0', STR_PAD_LEFT);
            $nome = "Usuário JellyCloud " . $numero;
            $email = "usuario" . $numero . "@jellycloud.com";
            $telefone = "(" . rand(11, 99) . ") " . rand(90000, 99999) . "-" . rand(1000, 9999);
            $senha = "JellyCloud123";

            $Db->query(
                "INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)",
                [
                    'name' => $nome,
                    'email' => $email,
                    'phone' => $telefone,
                    'password' => $senha
                ]
            );

            if ($Db->getLastError()) {
                throw new \Exception($Db->getLastError());
            }
        }

        echo "✅ Lote " . ($lote + 1) . " concluído.\n";
    }

    echo "\n🎉 Inserção concluída com sucesso!\n";
    echo "📈 Total de registros inseridos: {$total}\n";
    echo "🍇 JellyCloud pronto para testes!\n";
} catch (\Exception $e) {
    echo "❌ Erro ao criar usuários: " . $e->getMessage() . PHP_EOL;
}
