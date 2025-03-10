<?php
namespace App\Models;

class Sensor extends Model {
    protected $table = 'Sensorer';

    public function getFeaturedSensors($limit = 3) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY price DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSensorsByBrand($brand) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE brand = :brand
            ORDER BY price
        ");
        $stmt->execute(['brand' => $brand]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSensorsByType($type) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE product_name LIKE :type OR features LIKE :type
            ORDER BY price
        ");
        $stmt->execute(['type' => '%' . $type . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}