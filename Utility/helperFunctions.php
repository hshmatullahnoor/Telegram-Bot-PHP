<?php


// Define env() helper if it doesn't exist
if (!function_exists('env')) {
    function env($key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}


// function to call all commands

function CallCommands()
{
    $commands = findCommands();

    foreach ($commands as $command) {
        $className = 'App\\Commands\\BotCommands\\' . $command;
        if (class_exists($className)) {
            try {
                $className::handle();
            } catch (Exception $e) {
                echo "Error calling command {$command}: " . $e->getMessage() . PHP_EOL;
            }
        } else {
            echo "Class {$className} does not exist." . PHP_EOL;
        }
    }
}

// function to find all commands

function findCommands()
{
    $dir = __DIR__ . '/App/Commands/BotCommands/';
    $files = scandir($dir);
    $commands = [];

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $commandName = pathinfo($file, PATHINFO_FILENAME);
            $commands[] = $commandName;
        }
    }

    return $commands;
}