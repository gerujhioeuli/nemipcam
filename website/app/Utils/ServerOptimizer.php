<?php
namespace App\Utils;

/**
 * ServerOptimizer - Handles server-side optimization tasks
 * 
 * This class provides methods for:
 * - PHP opcode caching configuration
 * - Server-side caching
 * - PHP configuration optimization
 * - Request/response compression
 */
class ServerOptimizer
{
    /**
     * @var ServerOptimizer Singleton instance
     */
    private static $instance = null;
    
    /**
     * @var array Cache storage
     */
    private $cache = [];
    
    /**
     * @var int Default cache TTL in seconds (5 minutes)
     */
    private $defaultTtl = 300;
    
    /**
     * @var string Cache directory
     */
    private $cacheDir = '';
    
    /**
     * Private constructor for singleton pattern
     */
    private function __construct()
    {
        $this->cacheDir = dirname(dirname(__DIR__)) . '/logs/cache';
        
        // Create cache directory if it doesn't exist
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
        
        // Apply optimal PHP settings
        $this->optimizePhpSettings();
    }
    
    /**
     * Get singleton instance
     * 
     * @return ServerOptimizer
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Apply optimal PHP settings for performance
     */
    private function optimizePhpSettings()
    {
        // Increase memory limit if needed
        if (ini_get('memory_limit') < '256M') {
            ini_set('memory_limit', '256M');
        }
        
        // Set optimal realpath cache size
        ini_set('realpath_cache_size', '4096k');
        ini_set('realpath_cache_ttl', '600');
        
        // Disable unnecessary functions
        if (!in_array('cli', $_SERVER['argv'] ?? [])) {
            ini_set('display_errors', '0');
            ini_set('log_errors', '1');
            ini_set('error_log', dirname(dirname(__DIR__)) . '/logs/php_errors.log');
        }
        
        // Set session cache limiter
        session_cache_limiter('private_no_expire');
        
        // Set output buffering
        if (ob_get_level() === 0) {
            ob_start('ob_gzhandler');
        }
    }
    
    /**
     * Configure OpCache if available
     * 
     * @return bool True if OpCache is enabled, false otherwise
     */
    public function configureOpCache()
    {
        if (!function_exists('opcache_get_status')) {
            return false;
        }
        
        // Check if OpCache is enabled
        if (!opcache_get_status(false)) {
            // Try to enable OpCache
            ini_set('opcache.enable', '1');
            ini_set('opcache.enable_cli', '1');
        }
        
        // Set optimal OpCache settings
        ini_set('opcache.memory_consumption', '128');
        ini_set('opcache.interned_strings_buffer', '8');
        ini_set('opcache.max_accelerated_files', '4000');
        ini_set('opcache.revalidate_freq', '60');
        ini_set('opcache.fast_shutdown', '1');
        ini_set('opcache.enable_file_override', '1');
        ini_set('opcache.validate_timestamps', '0'); // Disable timestamp validation in production
        
        return opcache_get_status(false) !== false;
    }
    
    /**
     * Get OpCache status information
     * 
     * @return array|bool OpCache status or false if not available
     */
    public function getOpCacheStatus()
    {
        if (!function_exists('opcache_get_status')) {
            return false;
        }
        
        return opcache_get_status();
    }
    
    /**
     * Reset OpCache
     * 
     * @return bool True if reset successful, false otherwise
     */
    public function resetOpCache()
    {
        if (!function_exists('opcache_reset')) {
            return false;
        }
        
        return opcache_reset();
    }
    
    /**
     * Cache data with a key
     * 
     * @param string $key Cache key
     * @param mixed $data Data to cache
     * @param int $ttl Time to live in seconds
     * @return bool True if cached successfully
     */
    public function cache($key, $data, $ttl = null)
    {
        $ttl = $ttl ?? $this->defaultTtl;
        
        $cacheData = [
            'data' => $data,
            'expires' => time() + $ttl
        ];
        
        // Store in memory cache
        $this->cache[$key] = $cacheData;
        
        // Store in file cache
        $cacheFile = $this->getCacheFilePath($key);
        file_put_contents($cacheFile, serialize($cacheData));
        
        return true;
    }
    
    /**
     * Get cached data by key
     * 
     * @param string $key Cache key
     * @return mixed|null Cached data or null if not found or expired
     */
    public function get($key)
    {
        // Check memory cache first
        if (isset($this->cache[$key])) {
            if ($this->cache[$key]['expires'] > time()) {
                return $this->cache[$key]['data'];
            }
            
            // Expired, remove from memory cache
            unset($this->cache[$key]);
        }
        
        // Check file cache
        $cacheFile = $this->getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            $cacheData = unserialize(file_get_contents($cacheFile));
            
            if ($cacheData['expires'] > time()) {
                // Store in memory cache for faster access next time
                $this->cache[$key] = $cacheData;
                return $cacheData['data'];
            }
            
            // Expired, remove file
            unlink($cacheFile);
        }
        
        return null;
    }
    
    /**
     * Check if a key exists in the cache and is not expired
     * 
     * @param string $key Cache key
     * @return bool True if key exists and is not expired
     */
    public function has($key)
    {
        // Check memory cache first
        if (isset($this->cache[$key])) {
            return $this->cache[$key]['expires'] > time();
        }
        
        // Check file cache
        $cacheFile = $this->getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            $cacheData = unserialize(file_get_contents($cacheFile));
            return $cacheData['expires'] > time();
        }
        
        return false;
    }
    
    /**
     * Delete a key from the cache
     * 
     * @param string $key Cache key
     * @return bool True if deleted or not found
     */
    public function delete($key)
    {
        // Remove from memory cache
        unset($this->cache[$key]);
        
        // Remove from file cache
        $cacheFile = $this->getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            return unlink($cacheFile);
        }
        
        return true;
    }
    
    /**
     * Clear all cache
     * 
     * @return bool True if cleared successfully
     */
    public function clear()
    {
        // Clear memory cache
        $this->cache = [];
        
        // Clear file cache
        $files = glob($this->cacheDir . '/*.cache');
        foreach ($files as $file) {
            unlink($file);
        }
        
        return true;
    }
    
    /**
     * Get cache file path for a key
     * 
     * @param string $key Cache key
     * @return string Cache file path
     */
    private function getCacheFilePath($key)
    {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
    
    /**
     * Start output buffering with compression
     * 
     * @return bool True if started successfully
     */
    public function startOutputBuffering()
    {
        if (ob_get_level() === 0) {
            return ob_start('ob_gzhandler');
        }
        
        return false;
    }
    
    /**
     * End output buffering and send compressed content
     * 
     * @return bool True if ended successfully
     */
    public function endOutputBuffering()
    {
        if (ob_get_level() > 0) {
            ob_end_flush();
            return true;
        }
        
        return false;
    }
    
    /**
     * Cache a page output
     * 
     * @param string $url Page URL
     * @param int $ttl Time to live in seconds
     * @return bool|string Cached content if exists, false otherwise
     */
    public function pageCache($url = null, $ttl = null)
    {
        $url = $url ?? $_SERVER['REQUEST_URI'];
        $key = 'page_' . md5($url);
        
        // Check if page is cached
        $cached = $this->get($key);
        if ($cached !== null) {
            return $cached;
        }
        
        // Start output buffering to capture page content
        ob_start();
        
        // Return false to indicate page is not cached
        return false;
    }
    
    /**
     * Save current output buffer to page cache
     * 
     * @param string $url Page URL
     * @param int $ttl Time to live in seconds
     * @return bool True if saved successfully
     */
    public function savePageCache($url = null, $ttl = null)
    {
        $url = $url ?? $_SERVER['REQUEST_URI'];
        $key = 'page_' . md5($url);
        
        // Get current output buffer content
        $content = ob_get_contents();
        
        // Cache the content
        $this->cache($key, $content, $ttl);
        
        return true;
    }
    
    /**
     * Set default cache TTL
     * 
     * @param int $ttl Time to live in seconds
     */
    public function setDefaultTtl($ttl)
    {
        $this->defaultTtl = $ttl;
    }
    
    /**
     * Get default cache TTL
     * 
     * @return int Default TTL in seconds
     */
    public function getDefaultTtl()
    {
        return $this->defaultTtl;
    }
} 