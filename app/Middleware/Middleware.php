<?php
namespace App\Middleware;

abstract class Middleware {
    /**
     * Handle the middleware
     * 
     * @param callable $next The next middleware to call
     * @return mixed
     */
    abstract public function handle($next);
} 