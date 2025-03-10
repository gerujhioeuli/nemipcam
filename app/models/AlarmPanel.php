<?php
namespace App\Models;

class AlarmPanel extends Model {
    protected $table = 'Alarmpaneler';

    public function getFeaturedPanels($limit = 3) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY price DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPanelsByBrand($brand) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE brand = :brand
            ORDER BY price
        ");
        $stmt->execute(['brand' => $brand]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPanelsByFeature($feature) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE features LIKE :feature
            ORDER BY price
        ");
        $stmt->execute(['feature' => '%' . $feature . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
} 