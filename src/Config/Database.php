<?php

namespace JellyCloud\Config;

/**
 * JellyCloud Database Configuration
 * 
 * Configurações de banco de dados do JellyCloud
 * Utiliza SQLite para simplicidade e portabilidade
 */
class Database {
    // Caminho para o arquivo do banco de dados SQLite
    const DB_PATH = DIR_DATA . '/jellycloud.sqlite';
    
    // Configurações do PDO
    const PDO_OPTIONS = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ];

    // DSN para conexão com SQLite
    public static function getDSN(): string {
        return 'sqlite:' . self::DB_PATH;
    }

    public static function getDBPath(): string {
        return self::DB_PATH;
    }
} 