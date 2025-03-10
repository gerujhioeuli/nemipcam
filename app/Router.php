<?php
namespace App;

use App\Middleware\MiddlewareHandler;

class Router {
    private $routes = [];
    private $notFoundCallback;
    private $middlewareHandler;

    public function __construct() {
        $this->middlewareHandler = new MiddlewareHandler();
    }

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
        return $this;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
        return $this;
    }

    public function put($path, $callback) {
        $this->routes['PUT'][$path] = $callback;
        return $this;
    }

    public function delete($path, $callback) {
        $this->routes['DELETE'][$path] = $callback;
        return $this;
    }

    public function notFound($callback) {
        $this->notFoundCallback = $callback;
        return $this;
    }

    public function middleware($middleware) {
        $this->middlewareHandler->add($middleware);
        return $this;
    }

    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove trailing slash if it exists
        $path = rtrim($path, '/');
        if (empty($path)) $path = '/';

        // Check if route exists
        if (isset($this->routes[$method][$path])) {
            $callback = $this->routes[$method][$path];
            
            return $this->middlewareHandler->run(function() use ($callback) {
                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $method = $callback[1];
                    return $controller->$method();
                }
                
                return $callback();
            });
        }

        // Check for dynamic routes with parameters
        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            // Skip non-dynamic routes
            if (strpos($route, '{') === false) {
                continue;
            }
            
            // Convert route pattern to regex
            $pattern = preg_replace('/{([a-zA-Z0-9_]+)}/', '([^/]+)', $route);
            $pattern = "#^$pattern$#";
            
            if (preg_match($pattern, $path, $matches)) {
                // Remove the first match (the full string)
                array_shift($matches);
                
                return $this->middlewareHandler->run(function() use ($callback, $matches) {
                    if (is_array($callback)) {
                        $controller = new $callback[0]();
                        $method = $callback[1];
                        return $controller->$method(...$matches);
                    }
                    
                    return call_user_func_array($callback, $matches);
                });
            }
        }

        // Handle 404
        if ($this->notFoundCallback) {
            return $this->middlewareHandler->run(function() {
                return call_user_func($this->notFoundCallback);
            });
        }

        throw new \Exception("Route not found");
    }
} 