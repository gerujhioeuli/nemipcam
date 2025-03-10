<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\AlarmPackage;
use App\Models\AlarmPanel;
use App\Models\Sensor;
use App\Models\Siren;
use App\Models\VideoSurveillance;

class ProductController extends Controller {
    private $productModel;
    private $categoryModel;
    private $brandModel;
    private $alarmPackageModel;
    private $alarmPanelModel;
    private $sensorModel;
    private $sirenModel;
    private $videoSurveillanceModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->brandModel = new Brand();
        $this->alarmPackageModel = new AlarmPackage();
        $this->alarmPanelModel = new AlarmPanel();
        $this->sensorModel = new Sensor();
        $this->sirenModel = new Siren();
        $this->videoSurveillanceModel = new VideoSurveillance();
    }

    public function index() {
        try {
            // Get popular products from all product tables
            $popularProducts = [];
            
            // Try to get products from each model
            try {
                $alarmPackages = $this->alarmPackageModel->findAll() ?? [];
                $popularProducts = array_merge($popularProducts, $alarmPackages);
            } catch (\Exception $e) {
                error_log("Error getting alarm packages: " . $e->getMessage());
            }
            
            try {
                $alarmPanels = $this->alarmPanelModel->findAll() ?? [];
                $popularProducts = array_merge($popularProducts, $alarmPanels);
            } catch (\Exception $e) {
                error_log("Error getting alarm panels: " . $e->getMessage());
            }
            
            try {
                $sensors = $this->sensorModel->findAll() ?? [];
                $popularProducts = array_merge($popularProducts, $sensors);
            } catch (\Exception $e) {
                error_log("Error getting sensors: " . $e->getMessage());
            }
            
            try {
                $sirens = $this->sirenModel->findAll() ?? [];
                $popularProducts = array_merge($popularProducts, $sirens);
            } catch (\Exception $e) {
                error_log("Error getting sirens: " . $e->getMessage());
            }
            
            try {
                $cameras = $this->videoSurveillanceModel->findAll() ?? [];
                $popularProducts = array_merge($popularProducts, $cameras);
            } catch (\Exception $e) {
                error_log("Error getting cameras: " . $e->getMessage());
            }
            
            // If no products found in specific tables, try the general products table
            if (empty($popularProducts)) {
                try {
                    $popularProducts = $this->productModel->findAll();
                } catch (\Exception $e) {
                    error_log("Error getting products: " . $e->getMessage());
                }
            }
            
            // Get categories
            $categories = [];
            try {
                $categories = $this->categoryModel->getActiveCategories();
            } catch (\Exception $e) {
                error_log("Error getting categories: " . $e->getMessage());
            }
            
            return $this->view('products/index', [
                'popularProducts' => $popularProducts,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            error_log("Product controller error: " . $e->getMessage());
            
            // Return view with empty data rather than showing an error
            return $this->view('products/index', [
                'popularProducts' => [],
                'categories' => []
            ]);
        }
    }

    public function show($id) {
        $product = $this->productModel->findById($id);
        
        if (!$product) {
            // Handle 404
            return $this->view('errors/404', [
                'message' => 'Product not found'
            ]);
        }
        
        // Get related products from the same category
        $relatedProducts = $this->productModel->findByCategory($product['category_id']);
        
        return $this->view('products/show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function search() {
        $query = $this->getQuery('q');
        
        if (empty($query)) {
            return $this->redirect('/products');
        }
        
        // Search in all product tables
        $results = [];
        
        // Add search results from each product type
        $this->addSearchResults($results, $this->alarmPackageModel->findAll(), $query);
        $this->addSearchResults($results, $this->alarmPanelModel->findAll(), $query);
        $this->addSearchResults($results, $this->sensorModel->findAll(), $query);
        $this->addSearchResults($results, $this->sirenModel->findAll(), $query);
        $this->addSearchResults($results, $this->videoSurveillanceModel->findAll(), $query);
        
        return $this->view('products/search', [
            'query' => $query,
            'products' => $results
        ]);
    }
    
    private function addSearchResults(&$results, $products, $query) {
        foreach ($products as $product) {
            if (
                stripos($product['product_name'], $query) !== false || 
                stripos($product['features'], $query) !== false ||
                stripos($product['brand'], $query) !== false
            ) {
                $results[] = $product;
            }
        }
    }

    public function byCategory($categoryId) {
        $category = $this->categoryModel->findById($categoryId);
        
        if (!$category) {
            // Handle 404
            return $this->view('errors/404', [
                'message' => 'Category not found'
            ]);
        }
        
        $products = $this->categoryModel->getProductsByCategory($categoryId);
        
        return $this->view('products/by_category', [
            'category' => $category,
            'products' => $products
        ]);
    }

    public function byBrand($brandId) {
        $brand = $this->brandModel->findById($brandId);
        
        if (!$brand) {
            // Handle 404
            return $this->view('errors/404', [
                'message' => 'Brand not found'
            ]);
        }
        
        $products = $this->brandModel->getProductsByBrand($brandId);
        
        return $this->view('products/by_brand', [
            'brand' => $brand,
            'products' => $products
        ]);
    }
} 