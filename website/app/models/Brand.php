<?php
namespace App\Models;

class Brand extends Model {
    protected $table = 'brand';

    public function getAllBrands() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getActiveBrands() {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY id
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductsByBrand($brandId) {
        $stmt = $this->db->prepare("
            SELECT * FROM products 
            WHERE brand_id = :brand_id
            ORDER BY id
        ");
        $stmt->execute(['brand_id' => $brandId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductCountByBrand() {
        $stmt = $this->db->prepare("
            SELECT b.id, COUNT(p.id) as product_count 
            FROM {$this->table} b
            LEFT JOIN products p ON p.brand_id = b.id
            GROUP BY b.id
            ORDER BY b.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
} 