<?php

namespace Awl\Orm;

class Database 
{
    public static function connect(): \PDO 
    {
        $host = trim($_ENV['DB_HOST']);
        $port = trim($_ENV['DB_PORT']);
        $dbname = trim($_ENV['DB_NAME']);
        
        // Build DSN string with correct host, port and database name
        $dsn = sprintf(
            "mysql:host=%s;port=%s;dbname=%s",
            $host,
            $port,
            $dbname
        );
        
        try {
            $pdo = new \PDO(
                $dsn, 
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]
            );
            return $pdo;
        } catch (\PDOException $e) {
            throw new \Exception("Connection failed: " . $e->getMessage());
        }
    }
}