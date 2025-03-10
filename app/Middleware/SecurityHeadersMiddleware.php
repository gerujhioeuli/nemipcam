<?php
namespace App\Middleware;

use App\Security\Security;

class SecurityHeadersMiddleware extends Middleware {
    /**
     * Handle the middleware
     * 
     * @param callable $next The next middleware to call
     * @return mixed
     */
    public function handle($next) {
        // Set security headers
        Security::setSecurityHeaders();
        
        // Proceed to next middleware
        return $next();
    }
} 