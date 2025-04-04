<?php

// save errors to a log file
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL);

use App\Commands\Kernal;

require_once 'autoload.php';

$update = file_get_contents('php://input');
$update = json_decode($update, true);

if ($update) {
    Kernal::init($update);
    CallCommands();
}

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
