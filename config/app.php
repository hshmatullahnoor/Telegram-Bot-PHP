<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


// سایر کدها
require_once dirname(__DIR__) . '/utility/helperFunctions.php';

$envConfig = [
    'debug' => env('DEBUG', true),
    'db_host' => env('DATABASE_HOST', 'localhost'),
    'db_name' => env('DATABASE_NAME', 'bot'),
    'db_user' => env('DATABASE_USER', 'root'),
    'db_pass' => env('DATABASE_PASS', ''),
    'db_port' => env('DATABASE_PORT', 3306),
    'telegram_token' => env('TELEGRAM_TOKEN', ''),
    'telegram_api_url' => env('TELEGRAM_API_URL', 'https://api.telegram.org/bot'),
    'domain_and_path' => env('DOMAIN_AND_PATH', 'https://f652-149-40-56-137.ngrok-free.app'),
    'telegram_webhook_url' => env('TELEGRAM_WEBHOOK_URL', 'https://f652-149-40-56-137.ngrok-free.app/telegram/webhook/'),
];

function app($key)
{
    global $envConfig;
    return $envConfig[$key] ?? null;
}

