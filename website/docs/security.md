# Security Implementation Documentation

## Overview
This document provides detailed information about the security features implemented in Phase 3 of the website enhancement project. The security implementation includes input validation, output escaping, CSRF protection, authentication, authorization, and security headers.

## Security Classes

### Security Class (`app/Security/Security.php`)
The `Security` class provides utility methods for various security features:

#### CSRF Protection
```php
// Generate a CSRF token
$token = Security::generateCsrfToken();

// Validate a CSRF token
if (!Security::validateCsrfToken($_POST['csrf_token'])) {
    // Invalid token
}
```

#### Input Validation
```php
// Define validation rules
$rules = [
    'name' => ['required' => true, 'minLength' => 2, 'maxLength' => 50],
    'email' => ['required' => true, 'type' => 'email'],
    'password' => ['required' => true, 'minLength' => 8],
    'age' => ['type' => 'numeric', 'required' => false],
    'website' => ['type' => 'url', 'required' => false],
    'date' => ['type' => 'date', 'required' => false],
    'custom_field' => [
        'required' => true,
        'pattern' => '/^[A-Z]{3}-\d{4}$/',
        'message' => 'Must be in format XXX-0000'
    ]
];

// Validate input
$errors = Security::validateInput($_POST, $rules);

// Check for errors
if (!empty($errors)) {
    // Handle validation errors
}
```

#### Output Escaping
```php
// Sanitize input to prevent XSS
$safeData = Security::sanitizeInput($_POST);

// Use in views
echo $safeData['name']; // Safely escaped
```

#### Security Headers
```php
// Set security headers
Security::setSecurityHeaders();
```

### Auth Class (`app/Security/Auth.php`)
The `Auth` class handles user authentication and authorization:

#### Authentication
```php
// Attempt to authenticate a user
if (Auth::attempt($email, $password)) {
    // Authentication successful
}

// Check if user is logged in
if (Auth::check()) {
    // User is logged in
}

// Get current user data
$user = Auth::user();

// Get current user ID
$userId = Auth::id();

// Log out the current user
Auth::logout();
```

#### Authorization
```php
// Check if user has a specific role
if (Auth::hasRole('admin')) {
    // User is an admin
}

// Check if user has one of multiple roles
if (Auth::hasRole(['admin', 'editor'])) {
    // User is either an admin or editor
}

// Check if user has a specific permission
if (Auth::hasPermission('edit_products')) {
    // User can edit products
}
```

## Middleware System

### Available Middleware
- `AuthMiddleware`: Ensures the user is authenticated
- `CsrfMiddleware`: Validates CSRF tokens for POST, PUT, DELETE requests
- `RoleMiddleware`: Ensures the user has the required role
- `PermissionMiddleware`: Ensures the user has the required permission
- `SecurityHeadersMiddleware`: Sets security headers for all responses

### Using Middleware in Routes
```php
// Apply middleware to all routes
$router->middleware(new SecurityHeadersMiddleware());
$router->middleware(new CsrfMiddleware());

// Apply middleware to specific routes
$router->get('/admin', [AdminController::class, 'index'])
    ->middleware(new AuthMiddleware())
    ->middleware(new RoleMiddleware('admin'));

$router->get('/products/edit/{id}', [ProductController::class, 'edit'])
    ->middleware(new AuthMiddleware())
    ->middleware(new PermissionMiddleware('edit_products'));
```

## Database Schema

### Users Table
```sql
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Permissions Table
```sql
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### User Permissions Table
```sql
CREATE TABLE IF NOT EXISTS `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_permission` (`user_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `user_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## Setup Instructions

1. Run the database setup script to create the necessary tables:
```bash
php database/setup_auth.php
```

2. This will create:
   - The `users`, `permissions`, and `user_permissions` tables
   - A default admin user with email `admin@example.com` and password `password`
   - Default permissions for various actions

3. Update the default admin password in production:
```php
$userModel = new \App\Models\User();
$userModel->updatePassword(1, 'new-secure-password');
```

## Best Practices

1. **Always validate user input**:
   - Use `Security::validateInput()` for all form submissions
   - Define appropriate validation rules for each field

2. **Always escape output**:
   - Use `Security::sanitizeInput()` before displaying user-provided data
   - Never echo unescaped user input directly

3. **Protect against CSRF**:
   - Include CSRF token in all forms
   - Validate the token on form submission

4. **Implement proper authorization**:
   - Use `Auth::check()` to verify authentication
   - Use `Auth::hasRole()` or `Auth::hasPermission()` for authorization
   - Apply appropriate middleware to routes

5. **Secure sensitive data**:
   - Never store passwords in plain text
   - Use environment variables for sensitive configuration
   - Limit access to sensitive information based on roles/permissions

## Security Headers

The following security headers are set by `SecurityHeadersMiddleware`:

- `X-XSS-Protection: 1; mode=block`: Enables XSS filtering
- `X-Content-Type-Options: nosniff`: Prevents MIME type sniffing
- `X-Frame-Options: SAMEORIGIN`: Protects against clickjacking
- `Strict-Transport-Security: max-age=31536000; includeSubDomains`: Enforces HTTPS
- `Content-Security-Policy`: Restricts resource loading to trusted sources
- `Referrer-Policy: strict-origin-when-cross-origin`: Controls referrer information
- `Permissions-Policy`: Restricts browser features

## Authentication Views

1. **Login Form** (`/login`):
   - Email and password fields
   - CSRF protection
   - Validation with error messages
   - Styled with `/assets/css/auth.css`

2. **Registration Form** (`/register`):
   - Name, email, password, and password confirmation fields
   - CSRF protection
   - Validation with error messages
   - Styled with `/assets/css/auth.css`

## Troubleshooting

1. **Authentication Issues**:
   - Ensure session is started with `session_start()`
   - Verify user exists in the database
   - Check password hashing is working correctly

2. **CSRF Protection Issues**:
   - Ensure session is started before generating tokens
   - Verify token is included in forms
   - Check token validation in controllers

3. **Authorization Issues**:
   - Verify user has the correct role assigned
   - Check permissions are properly assigned to users
   - Ensure middleware is applied to routes correctly 