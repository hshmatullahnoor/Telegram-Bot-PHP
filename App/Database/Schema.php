<?php

namespace App\Database;

use App\Database\Connection;
use PDO;

class Schema extends Connection
{
    private static string $tableName;
    private static string $select;
    private array $whereConditions = [];
    private array $values = [];

    public static function table(string $tableName): self
    {
        self::$tableName = $tableName;
        return new self();
    }

    public function select(string | array $columns): self
    {
        if (is_array($columns)) {
            self::$select = implode(", ", $columns);
        } else {
            self::$select = $columns;
        }
        return $this;
    }

    public function where(string $column, string $operator, mixed $value): self
    {
        $this->whereConditions[] = "$column $operator ?";
        $this->values[] = $value;
        return $this;
    }

    public function get(): array
    {
        $query = "SELECT " . self::$select . " FROM " . self::$tableName;
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $this->whereConditions);
        }

        $stmt = self::prepare($query);
        $stmt->execute($this->values);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first()
    {
        $query = "SELECT " . self::$select . " FROM " . self::$tableName;
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $this->whereConditions);
        }
        $query .= " LIMIT 1";

        $stmt = self::prepare($query);
        $stmt->execute($this->values);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function insert(array $data): bool
    {
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_fill(0, count($data), "?"));

        $query = "INSERT INTO " . self::$tableName . " ($columns) VALUES ($values)";
        $stmt = self::prepare($query);
        return $stmt->execute(array_values($data));
    }

    public function update(array $data): bool
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
            array_unshift($this->values, $value);
        }

        $query = "UPDATE " . self::$tableName . " SET " . implode(", ", $set);
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $this->whereConditions);
        }

        $stmt = self::prepare($query);
        return $stmt->execute($this->values);
    }

    public function delete(): bool
    {
        $query = "DELETE FROM " . self::$tableName;
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $this->whereConditions);
        }

        $stmt = self::prepare($query);
        return $stmt->execute($this->values);
    }

    public function count(): int
    {
        $query = "SELECT COUNT(*) as count FROM " . self::$tableName;
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $this->whereConditions);
        }

        $stmt = self::prepare($query);
        $stmt->execute($this->values);
        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }



    public function findOrInsert(array $data, string $column, string|int $value): ?array
    {
        if ($value === null) {
            return null;
        }

        $result = $this->where($column, '=', $value)->first();
        if ($result) {
            return $result;
        }

        self::insert($data);
        return $this->where($column, '=', $value)->first();
    }
}
