<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Fix subdirectory deployment - strip the subfolder prefix from REQUEST_URI
$subDir = '/admin-dashboard7Z';
if (isset($_SERVER['REQUEST_URI']) && str_starts_with($_SERVER['REQUEST_URI'], $subDir)) {
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($subDir)) ?: '/';
    $_SERVER['SCRIPT_NAME'] = $subDir . '/index.php';
}

if (isset($_GET['debug_uri'])) {
    die('Final REQUEST_URI: ' . $_SERVER['REQUEST_URI']);
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
