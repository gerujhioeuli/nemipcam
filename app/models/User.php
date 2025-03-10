<?php
namespace App\Models;

class User extends Model {
    protected $table = 'users';
    
    /**
     * Find a user by email
     * 
     * @param string $email The email to search for
     * @return array|false The user data, or false if not found
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Create a new user
     * 
     * @param array $data The user data
     * @return int The ID of the new user
     */
    public function register($data) {
        // Hash the password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Set default role if not provided
        if (!isset($data['role'])) {
            $data['role'] = 'user';
        }
        
        return $this->create($data);
    }
    
    /**
     * Update a user's password
     * 
     * @param int $id The user ID
     * @param string $password The new password
     * @return bool Whether the update was successful
     */
    public function updatePassword($id, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->update($id, ['password' => $hashedPassword]);
    }
    
    /**
     * Get a user's permissions
     * 
     * @param int $userId The user ID
     * @return array The user's permissions
     */
    public function getPermissions($userId) {
        $stmt = $this->db->prepare("
            SELECT p.name
            FROM permissions p
            JOIN user_permissions up ON p.id = up.permission_id
            WHERE up.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        
        $permissions = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $permissions[] = $row['name'];
        }
        
        return $permissions;
    }
} 