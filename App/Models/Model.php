<?php

namespace App\Models;

use App\Database\Schema;
use DateTime;
use PDO;

class Model extends Schema
{
    protected static string $tableName;
    protected static string $primaryKey = 'id';
    protected array $attributes = [];
    protected array $fillable = [];
    protected array $hidden = [];
    protected bool $timestamps = true;
    protected static ?Model $instance = null;
    protected ?string $currentQuery = null;
    protected array $queryParams = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        if (in_array($name, $this->fillable) || empty($this->fillable)) {
            $this->attributes[$name] = $value;
        }
    }

    public function __isset(string $name): bool
    {
        return isset($this->attributes[$name]);
    }

    public static function query(): self
    {
        return self::table(static::$tableName);
    }

    public static function find($id): ?self
    {
        $query = "SELECT * FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = ?";
        $result = self::executeQuery($query, [$id]);
        return $result ? new static($result[0]) : null;
    }

    public static function all(): array
    {
        $query = "SELECT * FROM " . static::$tableName;
        $results = self::executeQuery($query);
        return array_map(fn($item) => new static($item), $results);
    }

    public static function condition(string $column, string $operator, mixed $value): self
    {
        return static::query()->where($column, $operator, $value);
    }

    public static function create(array $data): self
    {
        $model = new static();
        $model->fill($data);
        $model->save();
        return $model;
    }

    public function fill(array $data): self
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    public function update(array $data): bool
    {
        $this->fill($data);
        return $this->save();
    }

    public function delete(): bool
    {
        $query = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . " = ?";
        return self::executeQuery($query, [$this->attributes[static::$primaryKey]]) !== false;
    }

    public function save(): bool
    {
        if ($this->timestamps) {
            $now = new DateTime();
            if (empty($this->attributes['created_at'])) {
                $this->attributes['created_at'] = $now->format('Y-m-d H:i:s');
            }
            $this->attributes['updated_at'] = $now->format('Y-m-d H:i:s');
        }

        if (isset($this->attributes[static::$primaryKey])) {
            return $this->performUpdate();
        }

        return $this->performInsert();
    }

    protected function performUpdate(): bool
    {
        $fields = [];
        $values = [];
        foreach ($this->attributes as $key => $value) {
            if ($key !== static::$primaryKey) {
                $fields[] = "{$key} = ?";
                $values[] = $value;
            }
        }
        $values[] = $this->attributes[static::$primaryKey];

        $query = "UPDATE " . static::$tableName . " SET " . implode(', ', $fields) .
            " WHERE " . static::$primaryKey . " = ?";
        return self::executeQuery($query, $values) !== false;
    }

    protected function performInsert(): bool
    {
        $fields = array_keys($this->attributes);
        $values = array_values($this->attributes);
        $placeholders = array_fill(0, count($fields), '?');

        $query = "INSERT INTO " . static::$tableName .
            " (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";

        $result = self::executeQuery($query, $values);
        if ($result !== false) {
            $this->attributes[static::$primaryKey] = self::getLastInsertId();
            return true;
        }
        return false;
    }

    protected function setQuery(string $query, array $params = []): self
    {
        $this->currentQuery = $query;
        $this->queryParams = $params;
        return $this;
    }

    protected static function executeQuery(string $query, array $params = []): mixed
    {
        $stmt = self::prepare($query);
        try {
            $success = $stmt->execute($params);
            return $success ? ($stmt->columnCount() > 0 ? $stmt->fetchAll(PDO::FETCH_ASSOC) : true) : false;
        } catch (\PDOException $e) {
            error_log("Query execution failed: " . $e->getMessage());
            return false;
        }
    }

    protected static function getLastInsertId(): string|false
    {
        return self::getInstance()->lastInsertId();
    }

    // Add relationship methods
    protected function hasOne(string $relatedModel, string $foreignKey, string $localKey = null): ?Model
    {
        $localKey = $localKey ?? static::$primaryKey;
        $instance = new $relatedModel();
        return $instance->query()
            ->where($foreignKey, '=', $this->attributes[$localKey])
            ->first();
    }

    protected function hasMany(string $relatedModel, string $foreignKey, string $localKey = null): array
    {
        $localKey = $localKey ?? static::$primaryKey;
        $instance = new $relatedModel();
        return $instance->query()
            ->where($foreignKey, '=', $this->attributes[$localKey])
            ->get();
    }

    protected function belongsTo(string $relatedModel, string $foreignKey, string $ownerKey = null): ?Model
    {
        $instance = new $relatedModel();
        $ownerKey = $ownerKey ?? $instance::$primaryKey;
        return $instance->query()
            ->where($ownerKey, '=', $this->attributes[$foreignKey])
            ->first();
    }

    protected function belongsToMany(
        string $relatedModel,
        string $pivotTable,
        string $foreignPivotKey,
        string $relatedPivotKey,
        string $localKey = null,
        string $relatedKey = null
    ): array {
        $localKey = $localKey ?? static::$primaryKey;
        $instance = new $relatedModel();
        $relatedKey = $relatedKey ?? $instance::$primaryKey;

        $query = "SELECT {$instance::$tableName}.* FROM {$instance::$tableName} "
            . "INNER JOIN {$pivotTable} ON {$instance::$tableName}.{$relatedKey} = {$pivotTable}.{$relatedPivotKey} "
            . "WHERE {$pivotTable}.{$foreignPivotKey} = ?";

        $results = self::executeQuery($query, [$this->attributes[$localKey]]);
        return array_map(fn($item) => new $relatedModel($item), $results);
    }
}
