<?php
namespace App\Models;

class Product extends Model {
    protected $table = 'products';

    public function getPopularProducts($limit = 3) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE is_popular = 1 
            ORDER BY created_at DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByCategory($categoryId) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE category_id = :category_id
        ");
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
} 