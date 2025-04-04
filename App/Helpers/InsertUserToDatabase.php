<?php

namespace App\Helpers;

use App\Database\Schema;

class InsertUserToDatabase extends Schema
{

    public static function check(string | int $userId, array $data, string $tableName = 'users', string $column = 'user_id'): ?array
    {

        return self::table($tableName)->findOrInsert($data, $column, $userId);
    }
}
