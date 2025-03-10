<?php
namespace App\Controllers;

use App\Models\User;
use App\Security\Auth;
use App\Security\Security;

class AuthController extends Controller {
    /**
     * Show the login form
     */
    public function loginForm() {
        $this->view('auth/login', [
            'csrf_token' => Security::generateCsrfToken()
        ]);
    }
    
    /**
     * Handle the login request
     */
    public function login() {
        // Validate CSRF token
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->view('auth/login', [
                'error' => 'Invalid CSRF token',
                'csrf_token' => Security::generateCsrfToken()
            ]);
            return;
        }
        
        // Validate input
        $data = Security::sanitizeInput($_POST);
        $rules = [
            'email' => ['required' => true, 'type' => 'email'],
            'password' => ['required' => true]
        ];
        
        $errors = Security::validateInput($data, $rules);
        
        if (!empty($errors)) {
            $this->view('auth/login', [
                'errors' => $errors,
                'email' => $data['email'] ?? '',
                'csrf_token' => Security::generateCsrfToken()
            ]);
            return;
        }
        
        // Attempt to authenticate
        if (Auth::attempt($data['email'], $data['password'])) {
            // Redirect to dashboard
            $this->redirect('/dashboard');
        } else {
            // Authentication failed
            $this->view('auth/login', [
                'error' => 'Invalid email or password',
                'email' => $data['email'] ?? '',
                'csrf_token' => Security::generateCsrfToken()
            ]);
        }
    }
    
    /**
     * Show the registration form
     */
    public function registerForm() {
        $this->view('auth/register', [
            'csrf_token' => Security::generateCsrfToken()
        ]);
    }
    
    /**
     * Handle the registration request
     */
    public function register() {
        // Validate CSRF token
        if (!Security::validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->view('auth/register', [
                'error' => 'Invalid CSRF token',
                'csrf_token' => Security::generateCsrfToken()
            ]);
            return;
        }
        
        // Validate input
        $data = Security::sanitizeInput($_POST);
        $rules = [
            'name' => ['required' => true, 'minLength' => 2, 'maxLength' => 50],
            'email' => ['required' => true, 'type' => 'email'],
            'password' => ['required' => true, 'minLength' => 8],
            'password_confirm' => ['required' => true]
        ];
        
        $errors = Security::validateInput($data, $rules);
        
        // Check if passwords match
        if ($data['password'] !== $data['password_confirm']) {
            $errors['password_confirm'] = 'Passwords do not match';
        }
        
        if (!empty($errors)) {
            $this->view('auth/register', [
                'errors' => $errors,
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'csrf_token' => Security::generateCsrfToken()
            ]);
            return;
        }
        
        // Check if email already exists
        $userModel = new User();
        if ($userModel->findByEmail($data['email'])) {
            $this->view('auth/register', [
                'error' => 'Email already exists',
                'name' => $data['name'] ?? '',
                'csrf_token' => Security::generateCsrfToken()
            ]);
            return;
        }
        
        // Register the user
        $userId = $userModel->register([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'user'
        ]);
        
        if ($userId) {
            // Log the user in
            Auth::attempt($data['email'], $data['password']);
            
            // Redirect to dashboard
            $this->redirect('/dashboard');
        } else {
            // Registration failed
            $this->view('auth/register', [
                'error' => 'Registration failed',
                'name' => $data['name'] ?? '',
                'email' => $data['email'] ?? '',
                'csrf_token' => Security::generateCsrfToken()
            ]);
        }
    }
    
    /**
     * Log the user out
     */
    public function logout() {
        Auth::logout();
        $this->redirect('/login');
    }
} 