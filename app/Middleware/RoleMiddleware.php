<?php
namespace App\Middleware;

use App\Security\Auth;

class RoleMiddleware extends Middleware {
    /**
     * The roles that are allowed to access the route
     * 
     * @var array
     */
    private $roles;
    
    /**
     * Create a new RoleMiddleware instance
     * 
     * @param array|string $roles The roles that are allowed to access the route
     */
    public function __construct($roles) {
        $this->roles = is_array($roles) ? $roles : [$roles];
    }
    
    /**
     * Handle the middleware
     * 
     * @param callable $next The next middleware to call
     * @return mixed
     */
    public function handle($next) {
        // Check if user is logged in and has the required role
        if (!Auth::check() || !Auth::hasRole($this->roles)) {
            // User doesn't have the required role
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        // User has the required role, proceed to next middleware
        return $next();
    }
} 