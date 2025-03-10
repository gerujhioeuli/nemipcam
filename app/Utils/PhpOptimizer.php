<?php
namespace App\Utils;

/**
 * PhpOptimizer - Applies optimal PHP settings
 * 
 * This class applies the PHP optimization settings from the configuration file.
 */
class PhpOptimizer
{
    /**
     * @var array PHP settings
     */
    private static $settings = [];
    
    /**
     * Initialize the PHP optimizer
     * 
     * @return void
     */
    public static function init()
    {
        // Load settings from configuration file
        self::$settings = require dirname(dirname(__DIR__)) . '/config/php_optimization.php';
        
        // Apply settings
        self::applySettings();
    }
    
    /**
     * Apply PHP settings
     * 
     * @return void
     */
    private static function applySettings()
    {
        foreach (self::$settings as $key => $value) {
            // Skip settings that can't be changed at runtime
            if (in_array($key, ['upload_max_filesize', 'post_max_size'])) {
                continue;
            }
            
            // Apply setting
            ini_set($key, $value);
        }
    }
    
    /**
     * Get current PHP settings
     * 
     * @return array Current PHP settings
     */
    public static function getCurrentSettings()
    {
        $current = [];
        
        foreach (self::$settings as $key => $value) {
            $current[$key] = ini_get($key);
        }
        
        return $current;
    }
    
    /**
     * Generate .htaccess PHP settings
     * 
     * @return string .htaccess PHP settings
     */
    public static function generateHtaccessSettings()
    {
        $htaccess = "# PHP Optimization Settings\n";
        
        foreach (self::$settings as $key => $value) {
            $htaccess .= "php_value {$key} {$value}\n";
        }
        
        return $htaccess;
    }
    
    /**
     * Generate php.ini settings
     * 
     * @return string php.ini settings
     */
    public static function generatePhpIniSettings()
    {
        $ini = "; PHP Optimization Settings\n";
        
        foreach (self::$settings as $key => $value) {
            $ini .= "{$key} = {$value}\n";
        }
        
        return $ini;
    }
    
    /**
     * Check if OpCache is available
     * 
     * @return bool True if OpCache is available
     */
    public static function isOpCacheAvailable()
    {
        return function_exists('opcache_get_status');
    }
    
    /**
     * Check if OpCache is enabled
     * 
     * @return bool True if OpCache is enabled
     */
    public static function isOpCacheEnabled()
    {
        if (!self::isOpCacheAvailable()) {
            return false;
        }
        
        $status = opcache_get_status(false);
        return $status !== false && $status['opcache_enabled'];
    }
    
    /**
     * Get OpCache memory usage
     * 
     * @return array|bool OpCache memory usage or false if not available
     */
    public static function getOpCacheMemoryUsage()
    {
        if (!self::isOpCacheAvailable()) {
            return false;
        }
        
        $status = opcache_get_status(false);
        return $status !== false ? $status['memory_usage'] : false;
    }
    
    /**
     * Get OpCache statistics
     * 
     * @return array|bool OpCache statistics or false if not available
     */
    public static function getOpCacheStatistics()
    {
        if (!self::isOpCacheAvailable()) {
            return false;
        }
        
        $status = opcache_get_status(false);
        return $status !== false ? $status['opcache_statistics'] : false;
    }
    
    /**
     * Reset OpCache
     * 
     * @return bool True if reset successful
     */
    public static function resetOpCache()
    {
        if (!function_exists('opcache_reset')) {
            return false;
        }
        
        return opcache_reset();
    }
} 