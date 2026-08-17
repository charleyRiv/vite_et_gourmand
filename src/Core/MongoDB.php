<?php
// @phpstan-ignore-next-line
use MongoDB\Client;
use MongoDB\Database;
use MongoDB\Collection;

require_once __DIR__ . '/../../vendor/autoload.php';

class MongoDBConnection
{
    private static ?Client $instance = null;

    private function __construct() {}

    public static function getInstance(): Client
    {
        if (self::$instance === null) {
            $uri = $_ENV['MONGODB_URI'] ?? 'mongodb://localhost:27017';
            self::$instance = new Client($uri);
        }
        return self::$instance;
    }

    public static function getDatabase(): Database
    {
        $dbName = $_ENV['MONGODB_DB'] ?? 'vite_et_gourmand_stats';
        return self::getInstance()->selectDatabase($dbName);
    }

    public static function getCollection(string $collection): Collection
    {
        return self::getDatabase()->selectCollection($collection);
    }
}