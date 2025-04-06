<?php

namespace App\Database;

use App\Database\Connection;
use PDO;

class Schema extends Connection
{
    protected static string $tableName;
    protected string $select = '*';
    protected array $whereConditions = [];
    protected array $values = [];

    public static function table(string $tableName): self
    {
        $instance = new self();
        $instance::$tableName = $tableName;
        return $instance;
    }

    protected function reset(): void
    {
        $this->whereConditions = [];
        $this->values = [];
    }

    public function select(string | array $columns): self
    {
        $this->select = is_array($columns) ? implode(", ", $columns) : $columns;
        return $this;
    }

    public function where(string $column, string $operator, mixed $value): self
    {
        $this->whereConditions[] = "$column $operator ?";
        $this->values[] = $value;
        return $this;
    }

    protected function buildQuery(): string
    {
        $query = "SELECT {$this->select} FROM " . static::$tableName;
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $this->whereConditions);
        }
        return $query;
    }

    public function get(): array
    {
        $query = $this->buildQuery();
        $stmt = self::prepare($query);
        $stmt->execute($this->values);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->reset();
        return $result;
    }

    public function first()
    {
        $query = $this->buildQuery() . " LIMIT 1";

        $stmt = self::prepare($query);
        $stmt->execute($this->values);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->reset();
        return $result;
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
        $result = $stmt->execute($this->values);
        $this->reset();
        return $result;
    }

    public function delete(): bool
    {
        $query = "DELETE FROM " . self::$tableName;
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $this->whereConditions);
        }

        $stmt = self::prepare($query);
        $result = $stmt->execute($this->values);
        $this->reset();
        return $result;
    }

    public function count(): int
    {
        $query = "SELECT COUNT(*) as count FROM " . self::$tableName;
        if (!empty($this->whereConditions)) {
            $query .= " WHERE " . implode(" AND ", $this->whereConditions);
        }

        $stmt = self::prepare($query);
        $stmt->execute($this->values);
        $result = (int) $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        $this->reset();
        return $result;
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
