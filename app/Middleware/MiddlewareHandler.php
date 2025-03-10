<?php
namespace App\Middleware;

class MiddlewareHandler {
    /**
     * The middleware stack
     * 
     * @var array
     */
    private $middleware = [];
    
    /**
     * Add middleware to the stack
     * 
     * @param Middleware $middleware The middleware to add
     * @return $this
     */
    public function add(Middleware $middleware) {
        $this->middleware[] = $middleware;
        return $this;
    }
    
    /**
     * Run the middleware stack
     * 
     * @param callable $target The target to run after all middleware
     * @return mixed
     */
    public function run(callable $target) {
        $next = $target;
        
        // Build the middleware stack
        foreach (array_reverse($this->middleware) as $middleware) {
            $next = function() use ($middleware, $next) {
                return $middleware->handle($next);
            };
        }
        
        // Run the middleware stack
        return $next();
    }
} 