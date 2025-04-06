<?php

use Utility\HelperCommands\Commands;
use Utility\HelperCommands\Migrations;
use Utility\HelperCommands\Models;
use Utility\HelperCommands\Tables;
use Utility\HelperCommands\Webhook;

require_once __DIR__ . '/config/app.php';


$argoments = $argv;



$action = isset($argoments[1]) ? $argoments[1] : null;

switch ($action) {
    case 'migrate':
        Migrations::make();
        break;
    case 'migrate:fresh':
        Migrations::fresh();
        break;
    case 'make:command':
        if (isset($argoments[2])) {
            Commands::makeCommand($argoments[2]);
        } else {
            echo "Please provide a command name." . PHP_EOL;
        }
        break;
    case 'delete:command':
        if (isset($argoments[2])) {
            Commands::deleteCommand($argoments[2]);
        } else {
            echo "Please provide a command name." . PHP_EOL;
        }
        break;
    case 'make:table':
        if (isset($argoments[2])) {
            Tables::makeTable($argoments[2]);
        } else {
            echo "Please provide a table name." . PHP_EOL;
        }
        break;
    case 'delete:table':
        if (isset($argoments[2])) {
            Tables::deleteTable($argoments[2]);
        } else {
            echo "Please provide a table name." . PHP_EOL;
        }
        break;
    case 'make:model':
        if (isset($argoments[2])) {
            Models::makeModel($argoments[2]);

            if (isset($argoments[3]) && $argoments[3] === '--table' || $argoments[3] === '-t') {
                Tables::makeTable($argoments[2]);
            }

        } else {
            echo "Please provide a model name." . PHP_EOL;
        }
        break;
    case 'delete:model':
        if (isset($argoments[2])) {
            Models::deleteModel($argoments[2]);
        } else {
            echo "Please provide a model name." . PHP_EOL;
        }
        break;
    case 'webhook:set':
        Webhook::set();
        break;
    case 'webhook:delete':
        Webhook::delete();
        break;
    default:
        help();
        break;
}


function help() {
    $helpMessage = "This is a helper script for managing database migrations, commands, and models.\n";
    $helpMessage .= "Usage:\n";
    $helpMessage .= "  php helper.php [command] [options]\n\n";
    $helpMessage .= "Available commands:\n";
    $helpMessage .= "  migrate               Create all database tables.\n";
    $helpMessage .= "  migrate:fresh         Drop and recreate all tables.\n";
    $helpMessage .= "  make:command [name]   Create a new bot command class.\n";
    $helpMessage .= "  delete:command [name] Delete a bot command class.\n";
    $helpMessage .= "  make:table [name]     Create a new database table class.\n";
    $helpMessage .= "  delete:table [name]   Delete a database table class.\n";
    $helpMessage .= "  make:model [name]     Create a new model class.\n";
    $helpMessage .= "  delete:model [name]   Delete a model class.\n";
    $helpMessage .= "  webhook:set           Set the webhook URL for the bot.\n";
    $helpMessage .= "  webhook:delete        Delete the webhook URL for the bot.\n";
    $helpMessage .= "  make:model --table    Create a new model class and a new database table class.\n";
    $helpMessage .= "\nOptions:\n";
    $helpMessage .= "  --table, -t           Create a new database table class along with the model class.\n";
    $helpMessage .= "\nExamples:\n";
    $helpMessage .= "  php helper.php make:model User --table\n";

    echo $helpMessage;
}

exit(0);
