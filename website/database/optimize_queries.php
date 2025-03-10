<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Database\DatabaseOptimizer;

// Get database connection
$dbOptimizer = DatabaseOptimizer::getInstance();
$db = $dbOptimizer->getConnection();

// Function to get all PHP files in a directory recursively
function getPHPFiles($dir) {
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
    
    return $files;
}

// Function to extract SQL queries from PHP files
function extractQueries($file) {
    $content = file_get_contents($file);
    $queries = [];
    
    // Match queries in prepare statements
    preg_match_all('/\$[a-zA-Z0-9_]+->prepare\(\s*["\'](.+?)["\']\s*\)/s', $content, $matches);
    if (!empty($matches[1])) {
        $queries = array_merge($queries, $matches[1]);
    }
    
    // Match queries in query method
    preg_match_all('/\$[a-zA-Z0-9_]+->query\(\s*["\'](.+?)["\']\s*\)/s', $content, $matches);
    if (!empty($matches[1])) {
        $queries = array_merge($queries, $matches[1]);
    }
    
    // Match queries in executeQuery method
    preg_match_all('/executeQuery\(\s*["\'](.+?)["\']/s', $content, $matches);
    if (!empty($matches[1])) {
        $queries = array_merge($queries, $matches[1]);
    }
    
    return $queries;
}

// Get all PHP files in the project
$phpFiles = array_merge(
    getPHPFiles(dirname(__DIR__) . '/app'),
    getPHPFiles(dirname(__DIR__) . '/public')
);

// Extract and optimize queries
$optimizedQueries = [];
$totalQueries = 0;

foreach ($phpFiles as $file) {
    $queries = extractQueries($file);
    $totalQueries += count($queries);
    
    foreach ($queries as $query) {
        // Skip non-SELECT queries
        if (stripos($query, 'SELECT') !== 0) {
            continue;
        }
        
        $optimizedQuery = $dbOptimizer->optimizeQuery($query);
        
        // Only add if the query was actually optimized
        if ($optimizedQuery !== $query) {
            $optimizedQueries[] = [
                'file' => $file,
                'original' => $query,
                'optimized' => $optimizedQuery
            ];
        }
    }
}

// Display results
echo "Query Optimization Results\n";
echo "========================\n\n";

echo "Total queries found: $totalQueries\n";
echo "Queries optimized: " . count($optimizedQueries) . "\n\n";

if (count($optimizedQueries) > 0) {
    echo "Optimized Queries:\n";
    echo "-----------------\n";
    
    foreach ($optimizedQueries as $index => $query) {
        echo ($index + 1) . ". File: " . $query['file'] . "\n";
        echo "   Original: " . $query['original'] . "\n";
        echo "   Optimized: " . $query['optimized'] . "\n\n";
    }
    
    // Save optimized queries to a file
    $filename = dirname(__DIR__) . '/logs/optimized_queries_' . date('Y-m-d_H-i-s') . '.json';
    file_put_contents($filename, json_encode($optimizedQueries, JSON_PRETTY_PRINT));
    
    echo "Optimized queries saved to: $filename\n";
} else {
    echo "No queries were optimized.\n";
}

// Release the database connection
$dbOptimizer->releaseConnection($db); 