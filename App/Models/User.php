<?php

namespace App\Models;

class User extends Model
{
    protected static string $tableName = 'users';
    protected static string $primaryKey = 'id';

    protected array $fillable = [

    ];

    public static function new(): self
    {
        return new static();
    }
}
