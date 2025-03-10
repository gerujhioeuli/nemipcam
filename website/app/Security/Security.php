<?php
namespace App\Security;

class Security {
    /**
     * Generate a CSRF token and store it in the session
     * 
     * @return string The generated CSRF token
     */
    public static function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate a CSRF token against the one stored in the session
     * 
     * @param string $token The token to validate
     * @return bool Whether the token is valid
     */
    public static function validateCsrfToken($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }
    
    /**
     * Sanitize input data to prevent XSS attacks
     * 
     * @param mixed $data The data to sanitize
     * @return mixed The sanitized data
     */
    public static function sanitizeInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitizeInput($value);
            }
            return $data;
        }
        
        // Convert special characters to HTML entities
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validate input data against a set of rules
     * 
     * @param array $data The data to validate
     * @param array $rules The validation rules
     * @return array An array of validation errors, or an empty array if validation passes
     */
    public static function validateInput($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            // Skip if field doesn't exist and it's not required
            if (!isset($data[$field]) && !isset($rule['required'])) {
                continue;
            }
            
            // Check required fields
            if (isset($rule['required']) && $rule['required'] && (!isset($data[$field]) || empty($data[$field]))) {
                $errors[$field] = 'This field is required';
                continue;
            }
            
            // Skip further validation if field is empty and not required
            if (!isset($data[$field]) || $data[$field] === '') {
                continue;
            }
            
            // Validate field based on type
            if (isset($rule['type'])) {
                switch ($rule['type']) {
                    case 'email':
                        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            $errors[$field] = 'Invalid email format';
                        }
                        break;
                    case 'numeric':
                        if (!is_numeric($data[$field])) {
                            $errors[$field] = 'Must be a number';
                        }
                        break;
                    case 'integer':
                        if (!filter_var($data[$field], FILTER_VALIDATE_INT)) {
                            $errors[$field] = 'Must be an integer';
                        }
                        break;
                    case 'url':
                        if (!filter_var($data[$field], FILTER_VALIDATE_URL)) {
                            $errors[$field] = 'Invalid URL format';
                        }
                        break;
                    case 'date':
                        if (!strtotime($data[$field])) {
                            $errors[$field] = 'Invalid date format';
                        }
                        break;
                }
            }
            
            // Validate min length
            if (isset($rule['minLength']) && strlen($data[$field]) < $rule['minLength']) {
                $errors[$field] = 'Minimum length is ' . $rule['minLength'] . ' characters';
            }
            
            // Validate max length
            if (isset($rule['maxLength']) && strlen($data[$field]) > $rule['maxLength']) {
                $errors[$field] = 'Maximum length is ' . $rule['maxLength'] . ' characters';
            }
            
            // Validate regex pattern
            if (isset($rule['pattern']) && !preg_match($rule['pattern'], $data[$field])) {
                $errors[$field] = $rule['message'] ?? 'Invalid format';
            }
            
            // Validate custom function
            if (isset($rule['custom']) && is_callable($rule['custom'])) {
                $customResult = $rule['custom']($data[$field]);
                if ($customResult !== true) {
                    $errors[$field] = $customResult;
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Set security headers to protect against common attacks
     */
    public static function setSecurityHeaders() {
        // Protect against XSS attacks
        header('X-XSS-Protection: 1; mode=block');
        
        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');
        
        // Protect against clickjacking
        header('X-Frame-Options: SAMEORIGIN');
        
        // Enable strict transport security (HSTS)
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        
        // Set content security policy
        header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; style-src 'self' https://cdnjs.cloudflare.com; img-src 'self' data:; font-src 'self' https://cdnjs.cloudflare.com;");
        
        // Referrer policy
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        // Feature policy
        header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
    }
} 