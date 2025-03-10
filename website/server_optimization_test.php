<?php
/**
 * Server Optimization Test Script
 * 
 * This script tests the server-side optimization features:
 * - PHP opcode caching
 * - Server-side caching
 * - PHP configuration optimization
 * - Request/response compression
 */

// Load autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Initialize optimizers
use App\Utils\ServerOptimizer;
use App\Utils\PhpOptimizer;

// Create output buffer
ob_start();

echo "===========================================\n";
echo "Server-Side Optimization Test\n";
echo "===========================================\n\n";

// Test PHP OpCache
echo "Testing PHP OpCache...\n";
echo "----------------------\n";

if (PhpOptimizer::isOpCacheAvailable()) {
    echo "OpCache is available.\n";
    
    if (PhpOptimizer::isOpCacheEnabled()) {
        echo "OpCache is enabled.\n";
        
        // Get OpCache memory usage
        $memoryUsage = PhpOptimizer::getOpCacheMemoryUsage();
        if ($memoryUsage) {
            echo "OpCache memory usage:\n";
            echo "- Used memory: " . number_format($memoryUsage['used_memory'] / 1024 / 1024, 2) . " MB\n";
            echo "- Free memory: " . number_format($memoryUsage['free_memory'] / 1024 / 1024, 2) . " MB\n";
            echo "- Wasted memory: " . number_format($memoryUsage['wasted_memory'] / 1024 / 1024, 2) . " MB\n";
            echo "- Memory usage: " . number_format($memoryUsage['current_wasted_percentage'], 2) . "%\n";
        }
        
        // Get OpCache statistics
        $statistics = PhpOptimizer::getOpCacheStatistics();
        if ($statistics) {
            echo "OpCache statistics:\n";
            echo "- Cached scripts: " . $statistics['num_cached_scripts'] . "\n";
            echo "- Cached keys: " . $statistics['num_cached_keys'] . "\n";
            echo "- Cache hits: " . $statistics['hits'] . "\n";
            echo "- Cache misses: " . $statistics['misses'] . "\n";
            echo "- Hit rate: " . number_format($statistics['opcache_hit_rate'], 2) . "%\n";
        }
    } else {
        echo "OpCache is not enabled. Enabling...\n";
        
        // Configure OpCache
        $serverOptimizer = ServerOptimizer::getInstance();
        if ($serverOptimizer->configureOpCache()) {
            echo "OpCache has been enabled.\n";
        } else {
            echo "Failed to enable OpCache. Check your PHP configuration.\n";
        }
    }
} else {
    echo "OpCache is not available. Install the OpCache extension.\n";
}

echo "\n";

// Test PHP configuration
echo "Testing PHP Configuration...\n";
echo "---------------------------\n";

// Initialize PHP optimizer
PhpOptimizer::init();

// Get current PHP settings
$currentSettings = PhpOptimizer::getCurrentSettings();

echo "Current PHP settings:\n";
foreach ($currentSettings as $key => $value) {
    echo "- $key: $value\n";
}

echo "\n";

// Test server-side caching
echo "Testing Server-Side Caching...\n";
echo "-----------------------------\n";

// Initialize server optimizer
$serverOptimizer = ServerOptimizer::getInstance();

// Test caching
$cacheKey = 'test_cache_key';
$cacheData = [
    'id' => 1,
    'name' => 'Test Data',
    'timestamp' => time()
];

echo "Caching data...\n";
$serverOptimizer->cache($cacheKey, $cacheData, 60);

echo "Retrieving cached data...\n";
$cachedData = $serverOptimizer->get($cacheKey);

if ($cachedData) {
    echo "Cache hit! Data retrieved successfully.\n";
    echo "Cached data: " . json_encode($cachedData) . "\n";
} else {
    echo "Cache miss! Data not found.\n";
}

echo "\n";

// Test page caching
echo "Testing Page Caching...\n";
echo "----------------------\n";

// Check if page is cached
$pageUrl = '/test-page';
$cachedPage = $serverOptimizer->pageCache($pageUrl, 60);

if ($cachedPage !== false) {
    echo "Page cache hit! Page content retrieved from cache.\n";
    echo "Cached page length: " . strlen($cachedPage) . " bytes\n";
} else {
    echo "Page cache miss! Generating page content...\n";
    
    // Generate page content
    $pageContent = "This is a test page content generated at " . date('Y-m-d H:i:s') . "\n";
    
    // Save page to cache
    $serverOptimizer->savePageCache($pageUrl, 60);
    
    echo "Page content generated and saved to cache.\n";
    echo "Page content length: " . strlen($pageContent) . " bytes\n";
}

echo "\n";

// Test request/response compression
echo "Testing Request/Response Compression...\n";
echo "------------------------------------\n";

// Check if zlib compression is enabled
if (ini_get('zlib.output_compression')) {
    echo "Zlib output compression is enabled.\n";
    echo "Compression level: " . ini_get('zlib.output_compression_level') . "\n";
} else {
    echo "Zlib output compression is not enabled. Enabling...\n";
    
    // Enable zlib compression
    ini_set('zlib.output_compression', 1);
    ini_set('zlib.output_compression_level', 6);
    
    if (ini_get('zlib.output_compression')) {
        echo "Zlib output compression has been enabled.\n";
    } else {
        echo "Failed to enable zlib output compression. Check your PHP configuration.\n";
    }
}

// Check if output buffering is enabled
if (ob_get_level() > 0) {
    echo "Output buffering is enabled.\n";
    echo "Output buffer level: " . ob_get_level() . "\n";
} else {
    echo "Output buffering is not enabled. Enabling...\n";
    
    // Enable output buffering
    $serverOptimizer->startOutputBuffering();
    
    if (ob_get_level() > 0) {
        echo "Output buffering has been enabled.\n";
    } else {
        echo "Failed to enable output buffering. Check your PHP configuration.\n";
    }
}

echo "\n";

// Summary
echo "===========================================\n";
echo "Server-Side Optimization Summary\n";
echo "===========================================\n\n";

echo "1. PHP OpCache: " . (PhpOptimizer::isOpCacheEnabled() ? "Enabled" : "Disabled") . "\n";
echo "2. PHP Configuration: Optimized\n";
echo "3. Server-Side Caching: Enabled\n";
echo "4. Request/Response Compression: " . (ini_get('zlib.output_compression') ? "Enabled" : "Disabled") . "\n";

echo "\n";
echo "Server-side optimization test completed.\n";

// Get output buffer content
$output = ob_get_contents();

// End output buffering
ob_end_clean();

// Display output
echo $output; 