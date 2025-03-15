<?php
class Database {
    private static $pool = []; // Pool de conexões
    private static $maxConnections = 5; // Limite máximo
    private static $currentConnections = 0;

    public static function getInstance() {
        // Reutiliza uma conexão existente, se houver
        if (count(self::$pool) > 0) {
            return array_pop(self::$pool);
        }

        // Limita o número de conexões abertas
        if (self::$currentConnections < self::$maxConnections) {
            $pdo = new PDO("mysql:host=localhost;dbname=seu_banco;charset=utf8", "usuario", "senha", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true // Conexão persistente
            ]);

            self::$currentConnections++;
            return $pdo;
        }

        // Espera se o limite foi atingido
        sleep(1);
        return self::getInstance();
    }

    public static function release(PDO $pdo) {
        self::$pool[] = $pdo; // Adiciona conexão de volta ao pool
    }
}
?>
