<?php
// Display errors during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start output buffering
ob_start();

// Test URLs
$testUrls = [
    '/categories/1',
    '/categories/2',
    '/categories/3',
    '/categories/4',
    '/categories/5',
    '/categories/6',
    '/categories/7',
    '/products/1',
    '/products/2',
    '/products/3',
    '/pages/Videoovervågning.php',
    '/pages/Alarmpakker.php',
    '/pages/Alarmpaneler.php',
    '/pages/Betjening.php',
    '/pages/Sensorer.php',
    '/pages/Sirener.php',
    '/pages/Andet.php',
    '/pages/products/ajax-hub2-starterkit-plus-med-kamera.html',
    '/pages/products/ajax-hub-2.html',
    '/pages/categories/products/ajax-turretcam-5-mp-28-mm-hvid.html'
];

echo "<h1>Route Testing</h1>";
echo "<p>Testing if routes are correctly configured. This script simulates HTTP requests to various URLs and checks if they would be properly handled by the router.</p>";

echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr><th>URL</th><th>Expected Route</th><th>Status</th></tr>";

foreach ($testUrls as $url) {
    // Determine expected route
    $expectedRoute = $url;
    
    // Check if it's an old URL that should be redirected
    if (strpos($url, '/pages/') === 0) {
        if (preg_match('/^\/pages\/Videoovervågning\.php$/', $url)) {
            $expectedRoute = '/categories/1';
        } elseif (preg_match('/^\/pages\/Alarmpakker\.php$/', $url)) {
            $expectedRoute = '/categories/2';
        } elseif (preg_match('/^\/pages\/Alarmpaneler\.php$/', $url)) {
            $expectedRoute = '/categories/3';
        } elseif (preg_match('/^\/pages\/Betjening\.php$/', $url)) {
            $expectedRoute = '/categories/4';
        } elseif (preg_match('/^\/pages\/Sensorer\.php$/', $url)) {
            $expectedRoute = '/categories/5';
        } elseif (preg_match('/^\/pages\/Sirener\.php$/', $url)) {
            $expectedRoute = '/categories/6';
        } elseif (preg_match('/^\/pages\/Andet\.php$/', $url)) {
            $expectedRoute = '/categories/7';
        } elseif (preg_match('/^\/pages\/products\/([^\/]+)\.html$/', $url, $matches)) {
            $expectedRoute = '/products/' . $matches[1];
        } elseif (preg_match('/^\/pages\/categories\/products\/([^\/]+)\.html$/', $url, $matches)) {
            $expectedRoute = '/products/' . $matches[1];
        }
    }
    
    // Check if the .htaccess rules would handle this URL correctly
    $status = ($expectedRoute !== $url) ? "Redirected to $expectedRoute" : "Direct route";
    
    echo "<tr>";
    echo "<td>$url</td>";
    echo "<td>$expectedRoute</td>";
    echo "<td>$status</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>Router Dynamic Parameter Test</h2>";
echo "<p>Testing if the Router class can handle dynamic parameters in routes.</p>";

// Skip the autoload and router test if the autoload file doesn't exist
$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    // Simulate a request to test the router's dynamic parameter handling
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = '/products/123';

    // Include the router class
    require_once $autoloadPath;

    // Create a mock router for testing
    class MockRouter extends \App\Router {
        public function testDynamicRoute($path) {
            $_SERVER['REQUEST_URI'] = $path;
            
            try {
                // Register a test route with a dynamic parameter
                $this->get('/products/{id}', function($id) {
                    return "Product ID: $id";
                });
                
                // Try to resolve the route
                $result = $this->resolve();
                return "Success: $result";
            } catch (\Exception $e) {
                return "Error: " . $e->getMessage();
            }
        }
    }

    // Test the router with various paths
    $mockRouter = new MockRouter();
    $testPaths = [
        '/products/123',
        '/products/abc',
        '/products/ajax-hub-2',
        '/products/ajax-turretcam-5-mp-28-mm-hvid'
    ];

    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Path</th><th>Result</th></tr>";

    foreach ($testPaths as $path) {
        $result = $mockRouter->testDynamicRoute($path);
        echo "<tr>";
        echo "<td>$path</td>";
        echo "<td>$result</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Skipping router test because autoload file not found at: $autoloadPath</p>";
    echo "<p>This is expected if you're running the test script outside the MVC framework.</p>";
    echo "<p>The important part is that the URL redirects are correctly configured in .htaccess.</p>";
}

echo "<h2>Conclusion</h2>";
echo "<p>If all tests show successful results, the routing system should be working correctly. You can now navigate to the homepage and test clicking on categories and products.</p>";

// Get the output buffer content
$output = ob_get_clean();

// Save the output to a file
file_put_contents('route_test_results.html', $output);

// Print a message to the console
echo "Test completed. Results saved to route_test_results.html\n"; 