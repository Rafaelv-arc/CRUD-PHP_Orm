<?php
require 'vendor/autoload.php';

class Cache {
    private static $redis;

    public static function getInstance() {
        if (!self::$redis) {
            self::$redis = new Predis\Client([
                'scheme' => 'tcp',
                'host'   => '127.0.0.1',
                'port'   => 6379,
            ]);
        }
        return self::$redis;
    }

    public static function get(string $key) {
        $data = self::getInstance()->get($key);
        return $data ? json_decode($data, true) : false;
    }

    public static function set(string $key, $value, int $ttl = 300): bool {
        self::getInstance()->setex($key, $ttl, json_encode($value));
        return true;
    }

    public static function delete(string $key): int {
        return self::getInstance()->del([$key]);
    }
}
?>
