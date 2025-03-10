<?php
/**
 * Bootstrap File
 * 
 * This file initializes the application and loads required components.
 */

// Load configuration
$config = require_once __DIR__ . '/../config/assets.php';

// Initialize asset optimization
require_once __DIR__ . '/Utils/AssetOptimizer.php';
require_once __DIR__ . '/Utils/ImageOptimizer.php';
require_once __DIR__ . '/Utils/AssetManager.php';

// Initialize server-side optimization
require_once __DIR__ . '/Utils/ServerOptimizer.php';
require_once __DIR__ . '/Utils/PhpOptimizer.php';

// Initialize asset manager with configuration
App\Utils\AssetManager::init($config);

// Initialize PHP optimizer
App\Utils\PhpOptimizer::init();

// Initialize server optimizer
$serverOptimizer = App\Utils\ServerOptimizer::getInstance();

// Configure OpCache if available
$serverOptimizer->configureOpCache();

// Add default CSS files
App\Utils\AssetManager::addCss('assets/css/style.css');
App\Utils\AssetManager::addCss('assets/css/telefonstyle.css', 'screen and (max-width: 768px)');
App\Utils\AssetManager::addCss('assets/css/lazy-loading.css');

// Add default JavaScript files
App\Utils\AssetManager::addJs('assets/js/lazy-load.js', true, false);
App\Utils\AssetManager::addJs('assets/js/image-optimization.js', true, false);

/**
 * Helper function to get CSS HTML
 * 
 * @return string HTML for CSS files
 */
function getCssHtml()
{
    return App\Utils\AssetManager::getCssHtml();
}

/**
 * Helper function to get JavaScript HTML
 * 
 * @return string HTML for JavaScript files
 */
function getJsHtml()
{
    return App\Utils\AssetManager::getJsHtml();
}

/**
 * Helper function to get lazy-loaded image HTML
 * 
 * @param string $src Image source path
 * @param string $alt Alt text for the image
 * @param array $attributes Additional attributes for the img tag
 * @return string HTML for lazy-loaded image
 */
function lazyImage($src, $alt = '', $attributes = [])
{
    return App\Utils\AssetManager::lazyImage($src, $alt, $attributes);
}

/**
 * Helper function to get responsive image HTML
 * 
 * @param string $src Base image source path
 * @param array $sizes Array of sizes with width and path
 * @param string $alt Alt text for the image
 * @param array $attributes Additional attributes for the img tag
 * @return string HTML for responsive image
 */
function responsiveImage($src, $sizes = [], $alt = '', $attributes = [])
{
    return App\Utils\AssetManager::responsiveImage($src, $sizes, $alt, $attributes);
}

/**
 * Helper function to cache data
 * 
 * @param string $key Cache key
 * @param mixed $data Data to cache
 * @param int $ttl Time to live in seconds
 * @return bool True if cached successfully
 */
function cacheData($key, $data, $ttl = null)
{
    return App\Utils\ServerOptimizer::getInstance()->cache($key, $data, $ttl);
}

/**
 * Helper function to get cached data
 * 
 * @param string $key Cache key
 * @return mixed|null Cached data or null if not found or expired
 */
function getCachedData($key)
{
    return App\Utils\ServerOptimizer::getInstance()->get($key);
}

/**
 * Helper function to check if page is cached
 * 
 * @param string $url Page URL
 * @param int $ttl Time to live in seconds
 * @return bool|string Cached content if exists, false otherwise
 */
function pageCache($url = null, $ttl = null)
{
    return App\Utils\ServerOptimizer::getInstance()->pageCache($url, $ttl);
}

/**
 * Helper function to save page to cache
 * 
 * @param string $url Page URL
 * @param int $ttl Time to live in seconds
 * @return bool True if saved successfully
 */
function savePageCache($url = null, $ttl = null)
{
    return App\Utils\ServerOptimizer::getInstance()->savePageCache($url, $ttl);
} 