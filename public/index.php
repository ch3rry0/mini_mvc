<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;
use Mini\Controllers\ProductController;
use Mini\Controllers\AuthController;
use Mini\Controllers\CartController;
use Mini\Controllers\OrderController;

// Démarrer la session
session_start();

// Table des routes de l'application e-commerce
$routes = [
    // Routes produits
    ['GET', '/', [ProductController::class, 'index']],
    ['GET', '/product', [ProductController::class, 'show']],
    
    // Routes authentification
    ['GET', '/login', [AuthController::class, 'login']],
    ['POST', '/login', [AuthController::class, 'loginPost']],
    ['GET', '/register', [AuthController::class, 'register']],
    ['POST', '/register', [AuthController::class, 'registerPost']],
    ['GET', '/logout', [AuthController::class, 'logout']],
    
    // Routes panier
    ['GET', '/cart', [CartController::class, 'index']],
    ['POST', '/cart/add', [CartController::class, 'add']],
    ['POST', '/cart/update', [CartController::class, 'update']],
    ['GET', '/cart/remove', [CartController::class, 'remove']],
    ['GET', '/cart/clear', [CartController::class, 'clear']],
    
    // Routes commandes
    ['GET', '/order/checkout', [OrderController::class, 'checkout']],
    ['POST', '/order/process', [OrderController::class, 'process']],
    ['GET', '/order/confirmation', [OrderController::class, 'confirmation']],
    ['GET', '/order/history', [OrderController::class, 'history']],
    ['GET', '/order/detail', [OrderController::class, 'detail']],
];

// Bootstrap du router
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);


