<?php

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Define the routes array
$routes = array(
    '/' => array('IndexController', 'index')
);

foreach ($routes as $url => $action) {

    $baseUri = explode('?', $_SERVER['REQUEST_URI']);

    if ($baseUri[0] === $url) {

        // Run this action, passing the parameters.
        $controller = new $action[0];
        $controller->{$action[1]}($baseUri[1] ?? null);

        break;
    }
}
