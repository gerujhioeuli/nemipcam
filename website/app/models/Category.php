<?php
namespace App\Models;

class Category extends Model {
    protected $table = 'kategorier';

    public function getAllCategories() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id");
        $stmt->execute();
        return $this->fixCategoryEncoding($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function getActiveCategories() {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY id
        ");
        $stmt->execute();
        return $this->fixCategoryEncoding($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function getProductsByCategory($categoryId) {
        $category = $this->findById($categoryId);
        
        if (!$category) {
            return [];
        }
        
        $tableName = $category['table_name'] ?? '';
        
        if (empty($tableName)) {
            return [];
        }
        
        $stmt = $this->db->prepare("SELECT * FROM {$tableName} ORDER BY id");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Fix encoding issues with category names
     * 
     * @param array $categories Array of category data
     * @return array Fixed categories
     */
    private function fixCategoryEncoding($categories) {
        foreach ($categories as &$category) {
            // Fix specific encoding issues
            if ($category['id'] == 1 && $category['slug'] == 'videoovervogning') {
                $category['navn'] = 'Videoovervågning';
            }
        }
        return $categories;
    }
} 