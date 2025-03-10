<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Database\DatabaseOptimizer;

// Get database optimizer instance
$dbOptimizer = DatabaseOptimizer::getInstance();

// Function to simulate a database operation
function simulateDatabaseOperation($dbOptimizer, $id) {
    // Get a connection from the pool
    $db = $dbOptimizer->getConnection();
    
    // Simulate some work
    echo "Connection $id: Executing query...\n";
    $start = microtime(true);
    
    // Execute a simple query
    $stmt = $db->query("SELECT SLEEP(0.5)");
    $stmt->fetchAll();
    
    $end = microtime(true);
    echo "Connection $id: Query executed in " . round(($end - $start) * 1000, 2) . " ms\n";
    
    // Return the connection to the pool
    $dbOptimizer->releaseConnection($db);
    echo "Connection $id: Released back to pool\n";
}

// Test connection pooling with multiple sequential operations
echo "Testing Database Connection Pooling\n";
echo "=================================\n\n";

echo "Sequential Operations:\n";
echo "---------------------\n";
$start = microtime(true);

for ($i = 1; $i <= 5; $i++) {
    simulateDatabaseOperation($dbOptimizer, $i);
}

$end = microtime(true);
echo "\nTotal time for sequential operations: " . round(($end - $start) * 1000, 2) . " ms\n\n";

// Test connection pooling with parallel operations (simulated)
echo "Parallel Operations (Simulated):\n";
echo "------------------------------\n";
$start = microtime(true);

// Create multiple connections at once
$connections = [];
for ($i = 1; $i <= 5; $i++) {
    $connections[$i] = $dbOptimizer->getConnection();
    echo "Connection $i: Acquired from pool\n";
}

// Simulate parallel work
foreach ($connections as $id => $db) {
    echo "Connection $id: Executing query...\n";
    $stmt = $db->query("SELECT SLEEP(0.1)");
    $stmt->fetchAll();
    echo "Connection $id: Query executed\n";
}

// Return all connections to the pool
foreach ($connections as $id => $db) {
    $dbOptimizer->releaseConnection($db);
    echo "Connection $id: Released back to pool\n";
}

$end = microtime(true);
echo "\nTotal time for parallel operations: " . round(($end - $start) * 1000, 2) . " ms\n\n";

// Test connection reuse
echo "Connection Reuse Test:\n";
echo "--------------------\n";

// Get a connection
$db1 = $dbOptimizer->getConnection();
echo "Got connection 1\n";

// Return it to the pool
$dbOptimizer->releaseConnection($db1);
echo "Released connection 1 back to pool\n";

// Get another connection (should be the same one)
$db2 = $dbOptimizer->getConnection();
echo "Got connection 2\n";

// Check if it's the same connection
if ($db1 === $db2) {
    echo "Success: Connection was reused from the pool\n";
} else {
    echo "Failure: Connection was not reused\n";
}

// Release the connection
$dbOptimizer->releaseConnection($db2);
echo "Released connection 2 back to pool\n";

echo "\nConnection pooling test completed\n"; 