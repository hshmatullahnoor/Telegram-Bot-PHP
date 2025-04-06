<?php

namespace Utility\HelperCommands;

use Exception;

class migrations
{
    public static function make()
    {
        $classFiles = self::FindFiles();

        foreach ($classFiles as $classFile) {
            $className = 'App\\Tables\\' . $classFile;
            if (class_exists($className)) {
                try {
                    $className::up();
                    echo "Table {$classFile} created successfully." . PHP_EOL;
                } catch (Exception $e) {
                    echo "Error creating table {$classFile}: " . $e->getMessage() . PHP_EOL;
                }
            } else {
                echo "Class {$className} does not exist." . PHP_EOL;
            }
        }
    }
    public static function fresh()
    {
        $classFiles = self::FindFiles();

        foreach ($classFiles as $classFile) {
            $className = 'App\\Tables\\' . $classFile;
            if (class_exists($className)) {
                try {
                    $className::down();
                    echo "Table {$classFile} dropped successfully." . PHP_EOL;
                } catch (Exception $e) {
                    echo "Error dropping table {$classFile}: " . $e->getMessage() . PHP_EOL;
                }
            } else {
                echo "Class {$className} does not exist." . PHP_EOL;
            }
        }

        echo "Creating Tables again..." . PHP_EOL;
        sleep(1);
        self::make();
    }

    public static function FindFiles()
    {
        $path = __DIR__ . '/../../App/Tables/';
        $files = scandir($path);
        $classFiles = [];

        foreach ($files as $file) {
            if (is_file($path . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $classFiles[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }

        return $classFiles;
    }
}
