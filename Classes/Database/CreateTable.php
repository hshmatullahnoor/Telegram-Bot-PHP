<?php

namespace Classes\Database;

use Classes\Database\Connection;
use PDO;

class CreateTable extends Connection
{
    private static string $tableName;
    private static array $columns = [];
    private static array $primaryKey = [];
    private static array $foreignKey = [];
    private static string $currentColumn;

    public static function table(string $tableName): self
    {
        self::$tableName = $tableName;
        return new self();
    }

    public function int(string $columnName, int $length = null): self
    {
        self::$currentColumn = $columnName;
        self::$columns[$columnName] = "INT" . ($length ? "($length)" : "");
        return $this;
    }

    public function varchar(string $columnName, int $length = 255): self
    {
        self::$currentColumn = $columnName;
        self::$columns[$columnName] = "VARCHAR($length)";
        return $this;
    }

    public function text(string $columnName): self
    {
        self::$currentColumn = $columnName;
        self::$columns[$columnName] = "TEXT";
        return $this;
    }

    public function datetime(string $columnName): self
    {
        self::$currentColumn = $columnName;
        self::$columns[$columnName] = "DATETIME";
        return $this;
    }

    public function primaryKey(): self
    {
        self::$primaryKey[] = self::$currentColumn;
        return $this;
    }

    public function autoIncrement(): self
    {
        self::$columns[self::$currentColumn] .= " AUTO_INCREMENT";
        return $this;
    }

    public function foreignKey(string $referenceTable, string $referenceColumn): self
    {
        self::$foreignKey[] = "FOREIGN KEY (" . self::$currentColumn . ") REFERENCES $referenceTable($referenceColumn)";
        return $this;
    }

    public function unique(): self
    {
        self::$columns[self::$currentColumn] .= " UNIQUE";
        return $this;
    }

    public function notNull(): self
    {
        self::$columns[self::$currentColumn] .= " NOT NULL";
        return $this;
    }

    public function default($value): self
    {
        self::$columns[self::$currentColumn] .= " DEFAULT '$value'";
        return $this;
    }

    public function index(): self
    {
        self::$columns[self::$currentColumn] .= " INDEX";
        return $this;
    }

    public static function drop(string $tableName): bool
    {
        $sql = "DROP TABLE IF EXISTS $tableName";
        try {
            $stmt = self::prepare($sql);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function nullable(): self
    {
        self::$columns[self::$currentColumn] .= " NULL";
        return $this;
    }

    public function create()
    {
        $columns = [];
        foreach (self::$columns as $name => $type) {
            $columns[] = "`$name` $type";
        }

        if (!empty(self::$primaryKey)) {
            $columns[] = "PRIMARY KEY (" . implode(", ", self::$primaryKey) . ")";
        }

        if (!empty(self::$foreignKey)) {
            $columns = array_merge($columns, self::$foreignKey);
        }

        $sql = "CREATE TABLE IF NOT EXISTS " . self::$tableName . " (";
        $sql .= implode(", ", $columns);
        $sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        try {
            $stmt = self::prepare($sql);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        } finally {
            self::$columns = [];
            self::$primaryKey = [];
            self::$foreignKey = [];
        }
    }
}
