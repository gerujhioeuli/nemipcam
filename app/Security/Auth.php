<?php
namespace App\Security;

class Auth {
    /**
     * Attempt to authenticate a user
     * 
     * @param string $email The user's email
     * @param string $password The user's password
     * @return bool Whether authentication was successful
     */
    public static function attempt($email, $password) {
        // Get the user from the database
        $userModel = new \App\Models\User();
        $user = $userModel->findByEmail($email);
        
        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Store user data in session
            self::login($user);
            return true;
        }
        
        return false;
    }
    
    /**
     * Log in a user by storing their data in the session
     * 
     * @param array $user The user data
     */
    public static function login($user) {
        // Remove sensitive data
        unset($user['password']);
        
        // Store user data in session
        $_SESSION['user'] = $user;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['logged_in'] = true;
        
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
    }
    
    /**
     * Log out the current user
     */
    public static function logout() {
        // Unset all session variables
        $_SESSION = [];
        
        // Delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
    }
    
    /**
     * Check if a user is logged in
     * 
     * @return bool Whether the user is logged in
     */
    public static function check() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Get the current user's data
     * 
     * @return array|null The user data, or null if not logged in
     */
    public static function user() {
        return self::check() ? $_SESSION['user'] : null;
    }
    
    /**
     * Get the current user's ID
     * 
     * @return int|null The user ID, or null if not logged in
     */
    public static function id() {
        return self::check() ? $_SESSION['user_id'] : null;
    }
    
    /**
     * Check if the current user has a specific role
     * 
     * @param string|array $roles The role(s) to check
     * @return bool Whether the user has the role
     */
    public static function hasRole($roles) {
        if (!self::check()) {
            return false;
        }
        
        $userRole = $_SESSION['user']['role'] ?? '';
        
        if (is_array($roles)) {
            return in_array($userRole, $roles);
        }
        
        return $userRole === $roles;
    }
    
    /**
     * Check if the current user has permission to perform an action
     * 
     * @param string $permission The permission to check
     * @return bool Whether the user has permission
     */
    public static function hasPermission($permission) {
        if (!self::check()) {
            return false;
        }
        
        // Admin has all permissions
        if (self::hasRole('admin')) {
            return true;
        }
        
        // Check user permissions
        $userPermissions = $_SESSION['user']['permissions'] ?? [];
        return in_array($permission, $userPermissions);
    }
} 