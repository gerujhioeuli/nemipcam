<?php
/**
 * PHP Optimization Configuration
 * 
 * This file contains optimal PHP settings for performance.
 * These settings can be applied via php.ini, .htaccess, or runtime.
 */

return [
    /**
     * Memory and execution settings
     */
    'memory_limit' => '256M',
    'max_execution_time' => 60,
    'max_input_time' => 60,
    
    /**
     * Error handling
     */
    'display_errors' => 0,
    'display_startup_errors' => 0,
    'log_errors' => 1,
    'error_reporting' => E_ALL & ~E_DEPRECATED & ~E_STRICT,
    'error_log' => dirname(__DIR__) . '/logs/php_errors.log',
    
    /**
     * File uploads
     */
    'file_uploads' => 1,
    'upload_max_filesize' => '10M',
    'post_max_size' => '10M',
    
    /**
     * Session settings
     */
    'session.gc_maxlifetime' => 1440,
    'session.gc_probability' => 1,
    'session.gc_divisor' => 100,
    'session.cookie_secure' => 1,
    'session.cookie_httponly' => 1,
    'session.use_only_cookies' => 1,
    'session.cache_limiter' => 'private_no_expire',
    
    /**
     * Zlib output compression
     */
    'zlib.output_compression' => 1,
    'zlib.output_compression_level' => 6,
    
    /**
     * OpCache settings
     */
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
    
    /**
     * Realpath cache
     */
    'realpath_cache_size' => '4096k',
    'realpath_cache_ttl' => 600,
    
    /**
     * Output buffering
     */
    'output_buffering' => 4096,
    
    /**
     * MySQL settings
     */
    'mysql.connect_timeout' => 60,
    'default_socket_timeout' => 60,
]; 