<?php

namespace Utility\HelperCommands;

class Tables
{
    public static function makeTable(string $tableName)
    {
        $tablePath = __DIR__ . '/../../App/Tables/' . $tableName . '.php';

        if (file_exists($tablePath)) {
            echo "Table {$tableName} already exists." . PHP_EOL;
            return;
        }

        $tableTemplate = "<?php\n\nnamespace App\\Tables;\n\nuse App\\Database\\CreateTable;\n\nclass $tableName extends CreateTable\n{\n    public static function up(): void\n    {\n        self::table('$tableName')\n            ->int('id')->primaryKey()->autoIncrement()\n            ->varchar('username', 255)->notNull()\n            // Add more columns as needed\n            ->create();\n    }\n\n    public static function down(): void\n    {\n        self::drop('$tableName');\n    }\n\n}";


        file_put_contents($tablePath, $tableTemplate);
        echo "Table {$tableName} created successfully." . PHP_EOL;
        echo "You can find it in {$tablePath}" . PHP_EOL;
    }

    public static function deleteTable(string $tableName)
    {
        $tablePath = __DIR__ . '/../../App/Tables/' . $tableName . '.php';

        if (file_exists($tablePath)) {
            unlink($tablePath);
            echo "Table {$tableName} deleted successfully." . PHP_EOL;
        } else {
            echo "Table {$tableName} does not exist." . PHP_EOL;
        }
    }
}

