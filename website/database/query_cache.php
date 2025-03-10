<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Database\DatabaseOptimizer;

// Get database optimizer instance
$dbOptimizer = DatabaseOptimizer::getInstance();
$db = $dbOptimizer->getConnection();

// Function to execute a query and measure time
function executeQuery($dbOptimizer, $db, $query, $params = [], $ttl = 300) {
    $start = microtime(true);
    $result = $dbOptimizer->executeQuery($db, $query, $params, $ttl);
    $end = microtime(true);
    
    return [
        'time' => round(($end - $start) * 1000, 2),
        'result' => $result
    ];
}

// Test query caching
echo "Testing Query Caching\n";
echo "===================\n\n";

// Clear the cache to start fresh
$dbOptimizer->clearCache();
echo "Cache cleared\n\n";

// Test with a simple query
$query = "SELECT * FROM products LIMIT 10";

// First execution (not cached)
echo "Executing query (not cached)...\n";
$result1 = executeQuery($dbOptimizer, $db, $query);
echo "Query executed in {$result1['time']} ms\n";
echo "Result count: " . count($result1['result']) . "\n\n";

// Second execution (should be cached)
echo "Executing query again (should be cached)...\n";
$result2 = executeQuery($dbOptimizer, $db, $query);
echo "Query executed in {$result2['time']} ms\n";
echo "Result count: " . count($result2['result']) . "\n\n";

// Calculate performance improvement
$improvement = $result1['time'] > 0 ? round(($result1['time'] - $result2['time']) / $result1['time'] * 100, 2) : 0;
echo "Performance improvement: $improvement%\n\n";

// Test with a more complex query
$query = "SELECT p.*, k.navn AS category_name 
          FROM products p 
          LEFT JOIN kategorier k ON p.kategori_id = k.id 
          WHERE p.price > :price 
          ORDER BY p.price DESC 
          LIMIT 5";
$params = ['price' => 1000];

// First execution (not cached)
echo "Executing complex query (not cached)...\n";
$result3 = executeQuery($dbOptimizer, $db, $query, $params);
echo "Query executed in {$result3['time']} ms\n";
echo "Result count: " . count($result3['result']) . "\n\n";

// Second execution (should be cached)
echo "Executing complex query again (should be cached)...\n";
$result4 = executeQuery($dbOptimizer, $db, $query, $params);
echo "Query executed in {$result4['time']} ms\n";
echo "Result count: " . count($result4['result']) . "\n\n";

// Calculate performance improvement
$improvement = $result3['time'] > 0 ? round(($result3['time'] - $result4['time']) / $result3['time'] * 100, 2) : 0;
echo "Performance improvement: $improvement%\n\n";

// Test cache invalidation
echo "Testing cache invalidation...\n";
$dbOptimizer->clearCache();
echo "Cache cleared\n";

// Execute query again (should not be cached)
echo "Executing query after cache clear...\n";
$result5 = executeQuery($dbOptimizer, $db, $query, $params);
echo "Query executed in {$result5['time']} ms\n";
echo "Result count: " . count($result5['result']) . "\n\n";

// Compare with cached result
$comparison = $result5['time'] > $result4['time'] ? "slower" : "faster";
echo "Execution after cache clear was $comparison than cached execution\n\n";

// Test cache with different parameters
$params2 = ['price' => 2000];

// Execute with different parameters (should not be cached)
echo "Executing query with different parameters...\n";
$result6 = executeQuery($dbOptimizer, $db, $query, $params2);
echo "Query executed in {$result6['time']} ms\n";
echo "Result count: " . count($result6['result']) . "\n\n";

// Execute with same parameters again (should be cached)
echo "Executing query with same parameters again...\n";
$result7 = executeQuery($dbOptimizer, $db, $query, $params2);
echo "Query executed in {$result7['time']} ms\n";
echo "Result count: " . count($result7['result']) . "\n\n";

// Calculate performance improvement
$improvement = $result6['time'] > 0 ? round(($result6['time'] - $result7['time']) / $result6['time'] * 100, 2) : 0;
echo "Performance improvement: $improvement%\n\n";

// Test cache expiration (simulated)
echo "Testing cache expiration (simulated)...\n";
echo "Setting short TTL (1 second)...\n";

// Execute with short TTL
$result8 = executeQuery($dbOptimizer, $db, $query, $params, 1);
echo "Query executed in {$result8['time']} ms\n";

// Wait for cache to expire
echo "Waiting for cache to expire (2 seconds)...\n";
sleep(2);

// Execute again after expiration
echo "Executing query after cache expiration...\n";
$result9 = executeQuery($dbOptimizer, $db, $query, $params, 1);
echo "Query executed in {$result9['time']} ms\n\n";

// Compare with cached result
$comparison = $result9['time'] > $result8['time'] ? "slower" : "faster";
echo "Execution after cache expiration was $comparison than initial execution\n\n";

echo "Query caching test completed\n";

// Release the database connection
$dbOptimizer->releaseConnection($db); 