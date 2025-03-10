<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Product;

try {
    $product = new Product();
    echo "Database connection successful!\n";
    
    // Try to get all products (this might fail if the table doesn't exist yet)
    try {
        $products = $product->findAll();
        echo "Found " . count($products) . " products.\n";
    } catch (\PDOException $e) {
        echo "Note: Products table doesn't exist yet. We'll create it next.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 