# Server-Side Optimization Documentation

This document provides information about the server-side optimization features implemented in the website.

## Table of Contents

1. [PHP OpCache](#php-opcache)
2. [Server-Side Caching](#server-side-caching)
3. [PHP Configuration Optimization](#php-configuration-optimization)
4. [Request/Response Compression](#requestresponse-compression)
5. [Usage Examples](#usage-examples)
6. [Performance Monitoring](#performance-monitoring)

## PHP OpCache

PHP OpCache improves PHP performance by storing precompiled script bytecode in shared memory, eliminating the need for PHP to load and parse scripts on each request.

### Configuration

OpCache is configured in the `config/php_optimization.php` file with the following settings:

```php
'opcache.enable' => 1,
'opcache.enable_cli' => 1,
'opcache.memory_consumption' => 128,
'opcache.interned_strings_buffer' => 8,
'opcache.max_accelerated_files' => 4000,
'opcache.revalidate_freq' => 60,
'opcache.fast_shutdown' => 1,
'opcache.enable_file_override' => 1,
'opcache.validate_timestamps' => 1, // Set to 0 in production
'opcache.save_comments' => 1,
```

### Implementation

OpCache is initialized in the `app/bootstrap.php` file:

```php
// Initialize PHP optimizer
App\Utils\PhpOptimizer::init();

// Initialize server optimizer
$serverOptimizer = App\Utils\ServerOptimizer::getInstance();

// Configure OpCache if available
$serverOptimizer->configureOpCache();
```

### Checking OpCache Status

You can check the OpCache status using the `PhpOptimizer` class:

```php
use App\Utils\PhpOptimizer;

// Check if OpCache is available
if (PhpOptimizer::isOpCacheAvailable()) {
    // Check if OpCache is enabled
    if (PhpOptimizer::isOpCacheEnabled()) {
        // Get OpCache memory usage
        $memoryUsage = PhpOptimizer::getOpCacheMemoryUsage();
        
        // Get OpCache statistics
        $statistics = PhpOptimizer::getOpCacheStatistics();
    }
}
```

## Server-Side Caching

Server-side caching improves performance by storing frequently accessed data in memory or on disk, reducing the need for expensive database queries or computations.

### Implementation

Server-side caching is implemented in the `ServerOptimizer` class with the following features:

- In-memory caching for fast access
- File-based caching for persistence
- Automatic cache expiration
- Page caching for full-page output

### Usage

You can use the server-side caching through the helper functions in `app/bootstrap.php`:

```php
// Cache data
cacheData('my_key', $data, 300); // Cache for 5 minutes

// Get cached data
$data = getCachedData('my_key');

// Cache a page
$cachedPage = pageCache('/my-page', 300);
if ($cachedPage === false) {
    // Page not cached, generate content
    // ...
    
    // Save page to cache
    savePageCache('/my-page', 300);
}
```

## PHP Configuration Optimization

PHP configuration optimization improves performance by setting optimal PHP settings for memory usage, error handling, session management, and more.

### Configuration

PHP settings are configured in the `config/php_optimization.php` file with the following settings:

```php
// Memory and execution settings
'memory_limit' => '256M',
'max_execution_time' => 60,
'max_input_time' => 60,

// Error handling
'display_errors' => 0,
'display_startup_errors' => 0,
'log_errors' => 1,
'error_reporting' => E_ALL & ~E_DEPRECATED & ~E_STRICT,
'error_log' => dirname(__DIR__) . '/logs/php_errors.log',

// Session settings
'session.gc_maxlifetime' => 1440,
'session.gc_probability' => 1,
'session.gc_divisor' => 100,
'session.cookie_secure' => 1,
'session.cookie_httponly' => 1,
'session.use_only_cookies' => 1,
'session.cache_limiter' => 'private_no_expire',

// Realpath cache
'realpath_cache_size' => '4096k',
'realpath_cache_ttl' => 600,
```

### Implementation

PHP settings are applied in the `PhpOptimizer` class and initialized in the `app/bootstrap.php` file:

```php
// Initialize PHP optimizer
App\Utils\PhpOptimizer::init();
```

## Request/Response Compression

Request/response compression reduces the size of HTTP responses, improving page load times and reducing bandwidth usage.

### Configuration

Compression is configured in the `.htaccess` file with the following settings:

```apache
# Enable compression
<IfModule mod_deflate.c>
    # Compress HTML, CSS, JavaScript, Text, XML and fonts
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/json
    # ... more MIME types ...
    
    # Set compression level
    DeflateCompressionLevel 9
    
    # Enable pre-compressed content
    <IfModule mod_rewrite.c>
        RewriteCond %{HTTP:Accept-Encoding} gzip
        RewriteCond %{REQUEST_FILENAME}.gz -f
        RewriteRule ^(.*)$ $1.gz [QSA,L]
    </IfModule>
</IfModule>
```

PHP output compression is also enabled in the `config/php_optimization.php` file:

```php
// Zlib output compression
'zlib.output_compression' => 1,
'zlib.output_compression_level' => 6,
```

### Implementation

Output compression is applied in the `ServerOptimizer` class with the following methods:

```php
// Start output buffering with compression
$serverOptimizer->startOutputBuffering();

// End output buffering and send compressed content
$serverOptimizer->endOutputBuffering();
```

## Usage Examples

### Caching Database Query Results

```php
use App\Models\Product;

function getProducts($categoryId) {
    $cacheKey = 'products_category_' . $categoryId;
    
    // Check if data is cached
    $products = getCachedData($cacheKey);
    
    if ($products === null) {
        // Data not cached, fetch from database
        $productModel = new Product();
        $products = $productModel->findByCategory($categoryId);
        
        // Cache the results for 5 minutes
        cacheData($cacheKey, $products, 300);
    }
    
    return $products;
}
```

### Caching Page Output

```php
// At the beginning of the page
$cachedPage = pageCache();

if ($cachedPage !== false) {
    // Page is cached, output cached content and exit
    echo $cachedPage;
    exit;
}

// Page is not cached, generate content
// ...

// At the end of the page
savePageCache();
```

## Performance Monitoring

You can monitor the performance of the server-side optimization using the `server_optimization_test.php` script, which provides information about:

- OpCache status and statistics
- PHP configuration settings
- Server-side caching performance
- Request/response compression status

To run the test script, navigate to the website root directory and run:

```
php server_optimization_test.php
```

## Conclusion

The server-side optimization features implemented in the website improve performance by:

1. Reducing PHP script compilation time with OpCache
2. Minimizing database queries with server-side caching
3. Optimizing PHP configuration for better performance
4. Reducing bandwidth usage with request/response compression

These optimizations result in faster page load times, reduced server load, and improved user experience. 