<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// @phpstan-ignore-next-line
use MongoDB\Client;
// @phpstan-ignore-next-line
use MongoDB\Database;
// @phpstan-ignore-next-line
use MongoDB\Collection;
class MongoDBConnection
{
    // @phpstan-ignore-next-line
    private static ?Client $instance = null;

    private function __construct() {}

    // @phpstan-ignore-next-line
    public static function getInstance(): Client
    {
        if (self::$instance === null) {
            $uri = $_ENV['MONGODB_URI'] ?? 'mongodb://localhost:27017';
            // @phpstan-ignore-next-line
            self::$instance = new Client($uri);
        }
        return self::$instance;
    }

    // @phpstan-ignore-next-line
    public static function getDatabase(): Database
    {
        $dbName = $_ENV['MONGODB_DB'] ?? 'vg_stats';
        return self::getInstance()->selectDatabase($dbName);
    }

    // @phpstan-ignore-next-line
    public static function getCollection(string $collection): Collection
    {
        return self::getDatabase()->selectCollection($collection);
    }
}