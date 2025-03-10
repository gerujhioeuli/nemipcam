<?php
namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\AlarmPackage;
use App\Models\AlarmPanel;
use App\Models\VideoSurveillance;

class HomeController extends Controller {
    private $productModel;
    private $categoryModel;
    private $alarmPackageModel;
    private $alarmPanelModel;
    private $videoSurveillanceModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->alarmPackageModel = new AlarmPackage();
        $this->alarmPanelModel = new AlarmPanel();
        $this->videoSurveillanceModel = new VideoSurveillance();
    }

    public function index() {
        try {
            // Get active categories
            $categories = $this->categoryModel->getActiveCategories();
            
            // Initialize arrays to prevent null values
            $featuredPackages = [];
            $featuredPanels = [];
            $featuredCameras = [];
            
            // Try to get featured products from different categories
            try {
                $featuredPackages = $this->alarmPackageModel->getFeaturedPackages(1) ?? [];
            } catch (\Exception $e) {
                // Log error but continue
                error_log("Error getting featured packages: " . $e->getMessage());
            }
            
            try {
                $featuredPanels = $this->alarmPanelModel->getFeaturedPanels(1) ?? [];
            } catch (\Exception $e) {
                // Log error but continue
                error_log("Error getting featured panels: " . $e->getMessage());
            }
            
            try {
                $featuredCameras = $this->videoSurveillanceModel->getFeaturedCameras(1) ?? [];
            } catch (\Exception $e) {
                // Log error but continue
                error_log("Error getting featured cameras: " . $e->getMessage());
            }
            
            // Combine featured products
            $popularProducts = array_merge(
                $featuredPackages,
                $featuredPanels,
                $featuredCameras
            );
            
            // If no products found, try to get from general products table
            if (empty($popularProducts)) {
                try {
                    $popularProducts = $this->productModel->getPopularProducts(3);
                } catch (\Exception $e) {
                    // Log error but continue
                    error_log("Error getting popular products: " . $e->getMessage());
                }
            }
            
            return $this->view('home/index', [
                'categories' => $categories,
                'popularProducts' => $popularProducts
            ]);
        } catch (\Exception $e) {
            // Log the error
            error_log("Home controller error: " . $e->getMessage());
            
            // Still show the home page without the maintenance message
            return $this->view('home/index', [
                'categories' => [],
                'popularProducts' => []
            ]);
        }
    }
    
    public function about() {
        return $this->view('home/about');
    }
    
    public function contact() {
        return $this->view('home/contact');
    }
} 