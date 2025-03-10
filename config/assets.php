<?php
/**
 * Asset Configuration
 * 
 * This file contains configuration settings for asset optimization.
 */

return [
    /**
     * Whether to combine CSS files
     */
    'combine_css' => true,
    
    /**
     * Whether to combine JavaScript files
     */
    'combine_js' => true,
    
    /**
     * Whether to minify CSS files
     */
    'minify_css' => true,
    
    /**
     * Whether to minify JavaScript files
     */
    'minify_js' => true,
    
    /**
     * Default image sizes for responsive images
     */
    'responsive_image_sizes' => [320, 640, 1024, 1920],
    
    /**
     * Default JPEG/PNG quality (0-100)
     */
    'image_quality' => 80,
    
    /**
     * Path to fallback image
     */
    'fallback_image' => 'assets/images/placeholder.jpg',
    
    /**
     * Cache directory for optimized assets
     */
    'cache_dir' => 'assets/cache',
    
    /**
     * Whether to use browser caching
     */
    'use_browser_cache' => true,
    
    /**
     * Browser cache lifetime in seconds (1 week)
     */
    'browser_cache_lifetime' => 604800,
]; 