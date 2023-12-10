<?php

require_once __DIR__.'/vendor/autoload.php';

// Define the routes array
$routes = array(
    '//' => array('IndexController', 'index')
);

foreach ($routes as $url => $action) {

    if ($_SERVER['REQUEST_URI'] . '/' === $url) {

        // Run this action, passing the parameters.
        $controller = new $action[0];
        $controller->{$action[1]}();

        break;
    }
}
