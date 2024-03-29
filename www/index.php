<?php
session_start();

use modules\core\Router;
define('ROOT', dirname(__FILE__));

spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});

$router = new Router;
$router->run();