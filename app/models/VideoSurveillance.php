<?php
namespace App\Models;

class VideoSurveillance extends Model {
    protected $table = 'Videoovervågning';

    public function getFeaturedCameras($limit = 3) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            ORDER BY price DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCamerasByBrand($brand) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE brand = :brand
            ORDER BY price
        ");
        $stmt->execute(['brand' => $brand]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCamerasByResolution($resolution) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE features LIKE :resolution
            ORDER BY price
        ");
        $stmt->execute(['resolution' => '%' . $resolution . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getIndoorCameras() {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE features LIKE :indoor AND features NOT LIKE :outdoor
            ORDER BY price
        ");
        $stmt->execute([
            'indoor' => '%indendørs%',
            'outdoor' => '%udendørs%'
        ]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOutdoorCameras() {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE features LIKE :outdoor
            ORDER BY price
        ");
        $stmt->execute(['outdoor' => '%udendørs%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
} 