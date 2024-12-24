<?php

require_once __DIR__ . '/../controllers/MainController.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/CartController.php';

$router = new AltoRouter();


$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$router->setBasePath($basePath);


$router->map('GET', '/', 'MainController#home', 'home');
$router->map('GET', '/about', 'MainController#about', 'about');

$router->map('GET', '/products', 'ProductController#list', 'product_list');
$router->map('GET', '/product/[i:id]', 'ProductController#detail', 'product_detail');



$router->map('GET', '/cart', 'CartController#show', 'cart_show');


$router->map('POST', '/cart/add', 'CartController#add', 'cart_add');


$router->map('POST', '/cart/remove', 'CartController#remove', 'cart_remove');


return $router;
