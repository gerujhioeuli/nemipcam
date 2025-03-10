<?php
// Display errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;
use App\Controllers\BrandController;
use App\Controllers\AuthController;
use App\Middleware\CsrfMiddleware;
use App\Middleware\SecurityHeadersMiddleware;

// Initialize Router
$router = new Router();

// Apply global middleware
$router->middleware(new SecurityHeadersMiddleware());
$router->middleware(new CsrfMiddleware());

// Define routes
// Auth routes
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);

// Home routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/contact', [HomeController::class, 'contact']);

// Product routes
$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/search', [ProductController::class, 'search']);
$router->get('/products/category/{id}', [ProductController::class, 'byCategory']);
$router->get('/products/brand/{id}', [ProductController::class, 'byBrand']);
$router->get('/products/{id}', [ProductController::class, 'show']);

// Category routes
$router->get('/categories', [CategoryController::class, 'index']);
$router->get('/categories/search', [CategoryController::class, 'search']);
$router->get('/categories/{id}', [CategoryController::class, 'show']);

// Brand routes
$router->get('/brands', [BrandController::class, 'index']);
$router->get('/brands/{id}', [BrandController::class, 'show']);

// 404 handler
$router->notFound(function() {
    http_response_code(404);
    require dirname(__DIR__) . '/app/views/errors/404.php';
});

// Resolve the route
try {
    $router->resolve();
} catch (Exception $e) {
    echo '<h1>Error</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    echo '<h2>Stack Trace</h2>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
} 