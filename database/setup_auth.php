<?php
// Load database configuration
$config = require dirname(__DIR__) . '/config/database.php';

// Use development configuration
$dbConfig = $config['development'];

try {
    // Connect to database
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read SQL file
    $sql = file_get_contents(__DIR__ . '/auth_tables.sql');
    
    // Execute SQL
    $pdo->exec($sql);
    
    echo "Authentication tables created successfully!\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 