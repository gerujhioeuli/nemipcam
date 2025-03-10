<?php
namespace App\Models;

class Siren extends Model {
    protected $table = 'Sirener';

    public function getFeaturedSirens($limit = 3) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY price DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSirensByBrand($brand) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE brand = :brand
            ORDER BY price
        ");
        $stmt->execute(['brand' => $brand]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getSirensByLocation($location) {
        // Location can be 'indoor' or 'outdoor'
        $locationTerm = $location === 'indoor' ? 'indendørs' : 'udendørs';
        
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE features LIKE :location
            ORDER BY price
        ");
        $stmt->execute(['location' => '%' . $locationTerm . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
} 