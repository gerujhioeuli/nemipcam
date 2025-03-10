<?php
namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller {
    private $categoryModel;
    private $productModel;

    public function __construct() {
        $this->categoryModel = new Category();
        $this->productModel = new Product();
    }

    public function index() {
        $categories = $this->categoryModel->getActiveCategories();
        
        return $this->view('categories/index', [
            'categories' => $categories
        ]);
    }

    public function show($id) {
        $category = $this->categoryModel->findById($id);
        
        if (!$category) {
            // Handle 404
            return $this->view('errors/404', [
                'message' => 'Category not found'
            ]);
        }
        
        $products = $this->categoryModel->getProductsByCategory($id);
        
        return $this->view('categories/show', [
            'category' => $category,
            'products' => $products
        ]);
    }

    public function search() {
        $query = $this->getQuery('q');
        
        if (empty($query)) {
            return $this->redirect('/categories');
        }
        
        $categories = $this->categoryModel->getAllCategories();
        $matchedCategories = [];
        
        foreach ($categories as $category) {
            if (
                (isset($category['navn']) && stripos($category['navn'], $query) !== false) ||
                (isset($category['name']) && stripos($category['name'], $query) !== false)
            ) {
                $matchedCategories[] = $category;
            }
        }
        
        return $this->view('categories/search', [
            'query' => $query,
            'categories' => $matchedCategories
        ]);
    }
} 