<?php


namespace App\Tables;

use App\Database\CreateTable;

class Config extends CreateTable
{

    public static function up(): void
    {
        self::table('config')
            ->int('id')->primaryKey()->autoIncrement()
            ->varchar('name', 255)->notNull()
            ->varchar('value', 255)->notNull()
            ->create();
    }



    public static function down(): void
    {
        self::drop('config');
    }
}
