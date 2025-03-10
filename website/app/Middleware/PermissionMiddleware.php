<?php
namespace App\Middleware;

use App\Security\Auth;

class PermissionMiddleware extends Middleware {
    /**
     * The permission that is required to access the route
     * 
     * @var string
     */
    private $permission;
    
    /**
     * Create a new PermissionMiddleware instance
     * 
     * @param string $permission The permission that is required to access the route
     */
    public function __construct($permission) {
        $this->permission = $permission;
    }
    
    /**
     * Handle the middleware
     * 
     * @param callable $next The next middleware to call
     * @return mixed
     */
    public function handle($next) {
        // Check if user is logged in and has the required permission
        if (!Auth::check() || !Auth::hasPermission($this->permission)) {
            // User doesn't have the required permission
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        // User has the required permission, proceed to next middleware
        return $next();
    }
} 