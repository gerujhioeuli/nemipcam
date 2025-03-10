<?php
namespace App\Controllers;

use App\Models\Brand;

class BrandController extends Controller {
    private $brandModel;

    public function __construct() {
        $this->brandModel = new Brand();
    }

    public function index() {
        $brands = $this->brandModel->getActiveBrands();
        $brandCounts = $this->brandModel->getProductCountByBrand();
        
        // Merge product counts with brands
        foreach ($brands as &$brand) {
            foreach ($brandCounts as $count) {
                if ($brand['id'] === $count['id']) {
                    $brand['product_count'] = $count['product_count'];
                    break;
                }
            }
            
            if (!isset($brand['product_count'])) {
                $brand['product_count'] = 0;
            }
        }
        
        return $this->view('brands/index', [
            'brands' => $brands
        ]);
    }

    public function show($id) {
        $brand = $this->brandModel->findById($id);
        
        if (!$brand) {
            // Handle 404
            return $this->view('errors/404', [
                'message' => 'Brand not found'
            ]);
        }
        
        $products = $this->brandModel->getProductsByBrand($id);
        
        return $this->view('brands/show', [
            'brand' => $brand,
            'products' => $products
        ]);
    }
} 