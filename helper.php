#!/usr/bin/env php
<?php

error_reporting(0);

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/config.php';


$argoments = $argv;



$action = isset($argoments[1]) ? $argoments[1] : null;

switch ($action) {
    case 'table:up':
        Make();
        break;
    case 'table:fresh':
        Fresh();
        break;
    case 'make:command':
        if (isset($argoments[2])) {
            makeCommand($argoments[2]);
        } else {
            echo "Please provide a command name." . PHP_EOL;
        }
        break;
    case 'delete:command':
        if (isset($argoments[2])) {
            deleteCommand($argoments[2]);
        } else {
            echo "Please provide a command name." . PHP_EOL;
        }
        break;
    case 'make:table':
        if (isset($argoments[2])) {
            makeTable($argoments[2]);
        } else {
            echo "Please provide a table name." . PHP_EOL;
        }
        break;
    case 'delete:table':
        if (isset($argoments[2])) {
            deleteTable($argoments[2]);
        } else {
            echo "Please provide a table name." . PHP_EOL;
        }
        break;
    case 'webhook:set':
        setWebHook();
        break;
    case 'webhook:delete':
        deleteWebHook();
        break;
    default:
        help();
        break;
}



function help()
{

    $row = "+--------------------------------+--------------------------------------------------+\n";

    // create a table of commands
    $table = makeHelpTable('table:up', 'Create all database tables.');
    $table .= $row;
    $table .= makeHelpTable('table:fresh', 'Drop and recreate all tables.');
    $table .= $row;
    $table .= makeHelpTable('make:command', 'Create a new bot command class.');
    $table .= $row;
    $table .= makeHelpTable('delete:command', 'Delete a bot command class.');
    $table .= $row;
    $table .= makeHelpTable('make:table', 'Create a new database table class.');
    $table .= $row;
    $table .= makeHelpTable('delete:table', 'Delete a database table class.');
    $table .= $row;
    $table .= makeHelpTable('webhook:set', 'Set the webhook URL for the bot.');
    $table .= $row;
    $table .= makeHelpTable('webhook:delete', 'Delete the webhook URL for the bot.');
    $table .= $row;

    echo "+--------------------------------+--------------------------------------------------+\n";
    echo "Usage: helper [command]\n";
    echo "+--------------------------------+--------------------------------------------------+\n";
    echo "| Command                        | Description                                      |\n";
    echo "+--------------------------------+--------------------------------------------------+\n";
    echo $table;
}

function makeHelpTable($command, $description)
{
    $command = str_pad($command, 30, ' ', STR_PAD_RIGHT);
    $description = str_pad($description, 49, ' ', STR_PAD_RIGHT);
    return "| {$command} | {$description} |\n";
}


function setWebHook()
{
    $url = TELEGRAM_API_URL . TELEGRAM_TOKEN . '/setWebhook?url=' . TELEGRAM_WEBHOOK_URL;
    $response = file_get_contents($url);

    $response = json_decode($response, true);

    if ($response['ok'] == true || $response['result'] == true) {
        echo "Webhook set successfully." . PHP_EOL;
    } else {
        echo $response['description'] . PHP_EOL;
    }
}

function deleteWebHook()
{
    $url = TELEGRAM_API_URL . TELEGRAM_TOKEN . '/deleteWebhook';
    $response = file_get_contents($url);

    $response = json_decode($response, true);

    if ($response['ok'] == true || $response['result'] == true) {
        echo "Webhook deleted successfully." . PHP_EOL;
    } else {
        echo $response['description'] . PHP_EOL;
    }
}


function FindFiles()
{
    $path = __DIR__ . '/App/Tables/';
    $files = scandir($path);
    $classFiles = [];

    foreach ($files as $file) {
        if (is_file($path . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            $classFiles[] = pathinfo($file, PATHINFO_FILENAME);
        }
    }

    return $classFiles;
}


function Make()
{
    $classFiles = FindFiles();

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

function Fresh()
{
    $classFiles = FindFiles();

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
    Make();
}

function makeTable($tableName)
{
    $tablePath = __DIR__ . '/App/Tables/' . $tableName . '.php';

    if (file_exists($tablePath)) {
        echo "Table {$tableName} already exists." . PHP_EOL;
        return;
    }

    $tableTemplate = <<<PHP
<?php


namespace App\Tables;

use App\Database\CreateTable;

class $tableName extends CreateTable
{
    
    public static function up(): void
    {
        self::table('$tableName')
            ->int('id')->primaryKey()->autoIncrement()
            ->varchar('username', 255)->notNull()
            // Add more columns as needed
            ->create();
    }

    

    public static function down(): void
    {
        self::drop('$tableName');
    }

}
PHP;

    file_put_contents($tablePath, $tableTemplate);
    echo "Table {$tableName} created successfully." . PHP_EOL;
    echo "You can find it in {$tablePath}" . PHP_EOL;
}

function deleteTable($tableName)
{
    $tablePath = __DIR__ . '/App/Tables/' . $tableName . '.php';

    if (file_exists($tablePath)) {
        unlink($tablePath);
        echo "Table {$tableName} deleted successfully." . PHP_EOL;
    } else {
        echo "Table {$tableName} does not exist." . PHP_EOL;
    }
}

function deleteCommand($command)
{
    $commandName = $command;
    $commandPath = __DIR__ . '/App/Commands/BotCommands/' . $commandName . '.php';

    if (file_exists($commandPath)) {
        unlink($commandPath);
        echo "Command {$commandName} deleted successfully." . PHP_EOL;
    } else {
        echo "Command {$commandName} does not exist." . PHP_EOL;
    }
}


function makeCommand($command)
{
    $commandName = $command;
    $commandPath = __DIR__ . '/App/Commands/BotCommands/' . $commandName . '.php';

    if (file_exists($commandPath)) {
        echo "Command {$commandName} already exists." . PHP_EOL;
        return;
    }

    $Commandtemplate = <<<PHP
<?php

namespace App\Commands\BotCommands;


use App\Commands\Kernal;
use App\Keyboards\Keyboards;
use App\Telegram\Telegram;

class \$commandName extends Kernal
{
    public static function handle()
    {

    // change the command name to your command name
    // make your favorite logic here

        if (self::\$text == '$commandName') {
            Telegram::sendMessage()
                ->chatId(self::\$chatId)
                ->text("Welcome to the bot! Please choose an option:")
                ->replyMarkup(Keyboards::mainKeyboard())
                ->send();
        }
    }
}
PHP;

    $commandContent = str_replace('$commandName', $commandName, $Commandtemplate);
    file_put_contents($commandPath, $commandContent);
    echo "Command {$commandName} created successfully." . PHP_EOL;
    echo "You can find it in {$commandPath}" . PHP_EOL;
}



exit(0);
