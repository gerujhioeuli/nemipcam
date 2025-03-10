<?php
namespace App\Models;

use App\Database\DatabaseOptimizer;

class Model {
    protected $db;
    protected $table;
    protected static $config;
    protected $dbOptimizer;

    public function __construct() {
        $this->dbOptimizer = DatabaseOptimizer::getInstance();
        $this->connectDB();
    }

    protected function connectDB() {
        if (!self::$config) {
            self::$config = require dirname(dirname(__DIR__)) . '/config/database.php';
        }

        $env = getenv('APP_ENV') ?: 'development';
        
        try {
            // Get connection from the pool
            $this->db = $this->dbOptimizer->getConnection($env);
        } catch(\Exception $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function __destruct() {
        // Return connection to the pool when done
        if ($this->db) {
            $env = getenv('APP_ENV') ?: 'development';
            $this->dbOptimizer->releaseConnection($this->db, $env);
        }
    }

    public function findAll($ttl = 300) {
        $query = "SELECT * FROM {$this->table}";
        return $this->dbOptimizer->executeQuery($this->db, $query, [], $ttl);
    }

    public function findById($id, $ttl = 300) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        return $this->dbOptimizer->executeQuery($this->db, $query, ['id' => $id], $ttl)[0] ?? null;
    }

    public function findBy($column, $value, $ttl = 300) {
        $query = "SELECT * FROM {$this->table} WHERE {$column} = :value";
        return $this->dbOptimizer->executeQuery($this->db, $query, ['value' => $value], $ttl);
    }

    public function findOneBy($column, $value, $ttl = 300) {
        $query = "SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1";
        $result = $this->dbOptimizer->executeQuery($this->db, $query, ['value' => $value], $ttl);
        return $result[0] ?? null;
    }

    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(function($key) {
            return ":$key";
        }, array_keys($data)));
        
        $query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        
        // Clear cache after write operation
        $this->dbOptimizer->clearCache();
        
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $sets = [];
        foreach (array_keys($data) as $column) {
            $sets[] = "$column = :$column";
        }
        $setString = implode(', ', $sets);
        
        $data['id'] = $id;
        
        $query = "UPDATE {$this->table} SET $setString WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute($data);
        
        // Clear cache after write operation
        $this->dbOptimizer->clearCache();
        
        return $result;
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute(['id' => $id]);
        
        // Clear cache after write operation
        $this->dbOptimizer->clearCache();
        
        return $result;
    }

    /**
     * Execute a custom query with caching
     * @param string $query SQL query
     * @param array $params Query parameters
     * @param int $ttl Cache time-to-live in seconds
     * @return array Query results
     */
    public function executeQuery($query, $params = [], $ttl = 300) {
        return $this->dbOptimizer->executeQuery($this->db, $query, $params, $ttl);
    }

    /**
     * Clear the query cache
     */
    public function clearCache() {
        $this->dbOptimizer->clearCache();
    }
} 