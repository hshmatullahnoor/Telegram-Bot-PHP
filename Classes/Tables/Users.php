<?php


namespace Classes\Tables;

use Classes\Database\CreateTable;

class Users extends CreateTable
{
    
    public static function up(): void
    {
        self::table('users')
            ->int('id')->primaryKey()->autoIncrement()
            ->int('user_id')->notNull()
            ->varchar('username', 255)->notNull()
            ->varchar('first_name', 255)->notNull()
            ->varchar('last_name', 255)->nullable()
            ->create();
    }

    

    public static function down(): void
    {
        self::drop('users');
    }

}