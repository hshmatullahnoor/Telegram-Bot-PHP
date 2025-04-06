<?php

namespace Utility\HelperCommands;

class Models
{
    private static string $modelPath = __DIR__ . '/../../App/Models/';

    public static function makeModel(string $modelName): void
    {
        $modelPath = self::$modelPath . $modelName . '.php';
        if (file_exists($modelPath)) {
            echo "Model already exists." . PHP_EOL;
            return;
        }

        $modelTemplate = "<?php\n\nnamespace App\\Models;\n\nclass User extends Model\n{\n    protected static string \$tableName = 'users';\n    protected static string \$primaryKey = 'id';\n    protected array \$fillable = [\n\n    ];\n\n    public static function new(): self\n    {\n        return new static();\n    }\n}";
        $modelTemplate = str_replace('User', $modelName, $modelTemplate);
        $modelTemplate = str_replace('users', strtolower($modelName) . 's', $modelTemplate);
        file_put_contents($modelPath, $modelTemplate);
        echo "Model created successfully." . PHP_EOL;
    }

    public static function deleteModel(string $modelName): void
    {
        $modelPath = self::$modelPath . $modelName . '.php';
        if (!file_exists($modelPath)) {
            echo "Model does not exist." . PHP_EOL;
            return;
        }

        unlink($modelPath);
        echo "Model deleted successfully." . PHP_EOL;
    }
}