<?php
// Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load database configuration
$config = require_once dirname(__DIR__) . '/config/database.php';
$dbConfig = $config['development'];

try {
    // Connect to database
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";
    $db = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Database Table Structure</h1>";
    
    // Check kategorier table
    echo "<h2>Kategorier Table</h2>";
    $stmt = $db->query("DESCRIBE kategorier");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        foreach ($column as $key => $value) {
            echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    
    // Show sample data
    echo "<h3>Sample Data</h3>";
    $stmt = $db->query("SELECT * FROM kategorier LIMIT 5");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($rows) > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        foreach (array_keys($rows[0]) as $header) {
            echo "<th>" . htmlspecialchars($header) . "</th>";
        }
        echo "</tr>";
        
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data found in kategorier table.</p>";
    }
    
    // Check brand table
    echo "<h2>Brand Table</h2>";
    $stmt = $db->query("DESCRIBE brand");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        foreach ($column as $key => $value) {
            echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    
    // Show sample data
    echo "<h3>Sample Data</h3>";
    $stmt = $db->query("SELECT * FROM brand LIMIT 5");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($rows) > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        foreach (array_keys($rows[0]) as $header) {
            echo "<th>" . htmlspecialchars($header) . "</th>";
        }
        echo "</tr>";
        
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No data found in brand table.</p>";
    }
    
} catch (PDOException $e) {
    echo "<h1>Database Error</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?> 