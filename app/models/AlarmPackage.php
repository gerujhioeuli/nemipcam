<?php
namespace App\Models;

class AlarmPackage extends Model {
    protected $table = 'Alarmpakker';

    public function getFeaturedPackages($limit = 3) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY price DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPackagesByBrand($brand) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE brand = :brand
            ORDER BY price
        ");
        $stmt->execute(['brand' => $brand]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPackagesByPriceRange($min, $max) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE price BETWEEN :min AND :max
            ORDER BY price
        ");
        $stmt->execute([
            'min' => $min,
            'max' => $max
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
} 