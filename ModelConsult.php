<?php
require_once "Database.php";
require_once "Cache.php";

class Model {
    protected static $table;

    public static function all() {
        $cacheKey = static::$table . "_all";
        $cachedData = Cache::get($cacheKey);

        if ($cachedData) {
            return $cachedData;
        }

        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM " . static::$table);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        Cache::set($cacheKey, $result);
        Database::release($pdo);
        
        return $result;
    }

    public static function find($id) {
        $cacheKey = static::$table . "_find_" . $id;
        $cachedData = Cache::get($cacheKey);

        if ($cachedData) {
            return $cachedData;
        }

        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        Cache::set($cacheKey, $result);
        Database::release($pdo);
        
        return $result;
    }

    public static function create($data) {
        $pdo = Database::getInstance();

        $keys = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        
        $stmt = $pdo->prepare("INSERT INTO " . static::$table . " ($keys) VALUES ($placeholders)");
        $stmt->execute(array_values($data));

        Cache::set(static::$table . "_all", false); // Invalida cache
        Database::release($pdo);
    }

    public static function update($id, $data) {
        $pdo = Database::getInstance();

        $set = implode(", ", array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt = $pdo->prepare("UPDATE " . static::$table . " SET $set WHERE id = ?");
        $stmt->execute([...array_values($data), $id]);

        Cache::set(static::$table . "_all", false);
        Cache::set(static::$table . "_find_$id", false);
        Database::release($pdo);
    }

    public static function delete($id) {
        $pdo = Database::getInstance();

        $stmt = $pdo->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);

        Cache::set(static::$table . "_all", false);
        Cache::set(static::$table . "_find_$id", false);
        Database::release($pdo);
    }
}
?>
