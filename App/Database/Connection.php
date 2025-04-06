<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static $connection = null;

    public static function connect()
    {
        try {
            require_once __DIR__ . '/../../config/app.php';

            $host = app('db_host');
            $dbName = app('db_name');
            $user = app('db_user');
            $pass = app('db_pass');
            $port = app('db_port');

            $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4;port=$port";

            self::$connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new PDOException("Database connection failed. Please check your configuration.");
        }
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
        try {
            $stmt = self::getInstance()->prepare($query);
            if ($stmt === false) {
                throw new PDOException("Failed to prepare statement");
            }
            return $stmt;
        } catch (PDOException $e) {
            error_log("Statement preparation failed: " . $e->getMessage());
            throw $e;
        }
    }
}
