<?php
namespace App\Middleware;

use App\Security\Auth;

class AuthMiddleware extends Middleware {
    /**
     * Handle the middleware
     * 
     * @param callable $next The next middleware to call
     * @return mixed
     */
    public function handle($next) {
        // Check if user is logged in
        if (!Auth::check()) {
            // Redirect to login page
            header('Location: /login');
            exit;
        }
        
        // User is logged in, proceed to next middleware
        return $next();
    }
} 