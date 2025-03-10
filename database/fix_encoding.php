<?php
/**
 * Fix encoding issues in the database
 * 
 * This script fixes the encoding issue with the Videoovervågning category
 * Run this script once to update the database
 */

// Include database configuration
require_once __DIR__ . '/../config/database.php';

// Get database configuration
$config = require __DIR__ . '/../config/database.php';
$env = 'development';
$dbConfig = $config[$env];

try {
    // Connect to database
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
    
    // Update the Videoovervågning category
    $stmt = $pdo->prepare("UPDATE kategorier SET navn = 'Videoovervågning' WHERE id = 1 AND slug = 'videoovervogning'");
    $result = $stmt->execute();
    
    if ($result) {
        echo "Successfully updated the Videoovervågning category encoding.\n";
    } else {
        echo "No changes were made. The category may already be fixed.\n";
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
} 