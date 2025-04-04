<?php

namespace App\Database;

use PDO;

require_once __DIR__ . '/../../config.php';

class Connection
{
    private static $host = DB_HOST;
    private static $username = DB_USER;
    private static $password = DB_PASS;
    private static $database = DB_NAME;
    private static ?PDO $connection = null;

    public static function connect()
    {
        // Create a connection
        self::$connection = new PDO(
            "mysql:host=" . self::$host . ";dbname=" . self::$database,
            self::$username,
            self::$password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public static function getInstance()
    {
        if (self::$connection === null) {
            self::connect();
        }
        return self::$connection;
    }

    public static function prepare($query)
    {
        return self::getInstance()->prepare($query);
    }
}
