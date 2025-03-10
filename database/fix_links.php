<?php
/**
 * Fix links to Videoovervogning.php in product pages
 * 
 * This script finds all HTML files that link to Videoovervogning.php
 * and updates them to link to Videoovervågning.php instead
 */

// Define directories to search
$directories = [
    __DIR__ . '/../pages/products',
    __DIR__ . '/../pages/categories/products',
    __DIR__ . '/../pages/categories'
];

// Counter for fixed files
$fixedFiles = 0;

// Process each directory
foreach ($directories as $directory) {
    if (!is_dir($directory)) {
        echo "Directory not found: $directory\n";
        continue;
    }
    
    // Get all HTML files in the directory
    $files = glob($directory . '/*.html') ?: [];
    $phpFiles = glob($directory . '/*.php') ?: [];
    $files = array_merge($files, $phpFiles);
    
    foreach ($files as $file) {
        // Read file content
        $content = file_get_contents($file);
        
        // Check if file contains the incorrect link
        if (strpos($content, 'Videoovervogning.php') !== false) {
            // Replace incorrect links
            $newContent = str_replace(
                ['href="../Videoovervogning.php"', 'href="../../Videoovervogning.php"'],
                ['href="../Videoovervågning.php"', 'href="../../Videoovervågning.php"'],
                $content
            );
            
            // Also fix any display text issues
            $newContent = str_replace(
                '<div class="unactive">Videoovervogning</div>',
                '<div class="unactive">Videoovervågning</div>',
                $newContent
            );
            
            // Save the updated content
            file_put_contents($file, $newContent);
            
            $fixedFiles++;
            echo "Fixed links in: " . basename($file) . "\n";
        }
    }
}

echo "\nFixed links in $fixedFiles files.\n";
echo "All links to Videoovervogning.php have been updated to Videoovervågning.php\n"; 