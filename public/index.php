<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/controllers/MainController.php';

$router = require_once __DIR__ . '/../src/router/routes.php';



$match = $router->match();

if ($match) {
    // On sépare la classe et la méthode
    [$controller, $method] = explode('#', $match['target']);

    // Les paramètres capturés par la route
    $params = $match['params']; // ex: ['id' => 10]

    if (class_exists($controller) && method_exists($controller, $method)) {
        // Passer les paramètres à la méthode
        // Par exemple si detail($id) attend un paramètre, on fait :
        (new $controller)->$method(...array_values($params));
    } else {
        (new MainController)->notFound();
    }
} else {
    (new MainController)->notFound();
}

