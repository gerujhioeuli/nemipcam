<?php
namespace App\Middleware;

use App\Security\Security;

class CsrfMiddleware extends Middleware {
    /**
     * Handle the middleware
     * 
     * @param callable $next The next middleware to call
     * @return mixed
     */
    public function handle($next) {
        // Only check CSRF token for POST, PUT, DELETE requests
        if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'PUT', 'DELETE'])) {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            
            if (!$token || !Security::validateCsrfToken($token)) {
                // CSRF token is invalid
                http_response_code(403);
                echo json_encode(['error' => 'CSRF token validation failed']);
                exit;
            }
        }
        
        // CSRF token is valid or not required, proceed to next middleware
        return $next();
    }
} 