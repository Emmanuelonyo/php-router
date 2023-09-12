<?php
require __DIR__ . "/../vendor/autoload.php";
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//set required environment variables
// $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'SMTP_USER', 'SMTP_HOST', 'SMTP_PORT', 'SMTP_PASS']);

use Emmanuelonyo\PhpRouter\Error\ErrorHandler;
use Emmanuelonyo\PhpRouter\Router;

$app = new Router();
try {

/* The line `require __DIR__ . "/src/routes/api.php";` is including the file `api.php` located in the
`src/routes` directory. This allows the code in `api.php` to be executed and any functions, classes,
or variables defined in that file to be accessible in the current script. */

require __DIR__ . "/src/routes/api.php";
require __DIR__ . "/src/routes/viewRoutes.php";

$app->makeNotfoundHandler(function(){
    ErrorHandler::Notfound("Route not found");
}); 


    $app->run();
    
} catch (\Throwable $th) {
    ErrorHandler::serverError("Somthing Went Wrong");
}