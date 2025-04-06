<?php


require_once dirname(__DIR__) . '/config/app.php';

$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $uri);
$tokenFromUrl = end($parts);

if ($tokenFromUrl !== getenv('TELEGRAM_TOKEN')) {
    http_response_code(403);
    echo 'Invalid token';
    exit;
}


if (app('debug')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', 'error.log');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

use App\Commands\Kernal;

$update = file_get_contents('php://input');
$update = json_decode($update, true);

if ($update) {
    Kernal::init($update);
    CallCommands();
}




