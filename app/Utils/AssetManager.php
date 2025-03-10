<?php
namespace App\Utils;

/**
 * AssetManager - Manages assets for the application
 * 
 * This class provides methods for:
 * - Loading CSS and JavaScript files
 * - Optimizing and combining assets
 * - Handling image optimization and lazy loading
 */
class AssetManager
{
    /**
     * CSS files to include
     */
    private static $cssFiles = [];
    
    /**
     * JavaScript files to include
     */
    private static $jsFiles = [];
    
    /**
     * Whether to combine CSS files
     */
    private static $combineCss = false;
    
    /**
     * Whether to combine JavaScript files
     */
    private static $combineJs = false;
    
    /**
     * Whether to minify CSS files
     */
    private static $minifyCss = false;
    
    /**
     * Whether to minify JavaScript files
     */
    private static $minifyJs = false;
    
    /**
     * Initialize the AssetManager
     * 
     * @param array $config Configuration options
     */
    public static function init($config = [])
    {
        // Set configuration options
        self::$combineCss = $config['combine_css'] ?? false;
        self::$combineJs = $config['combine_js'] ?? false;
        self::$minifyCss = $config['minify_css'] ?? false;
        self::$minifyJs = $config['minify_js'] ?? false;
        
        // Initialize the AssetOptimizer
        AssetOptimizer::init();
        
        // Initialize the ImageOptimizer
        ImageOptimizer::init();
    }
    
    /**
     * Add a CSS file
     * 
     * @param string $file Path to CSS file relative to public directory
     * @param string $media Media attribute for the link tag
     */
    public static function addCss($file, $media = 'all')
    {
        self::$cssFiles[] = [
            'file' => $file,
            'media' => $media
        ];
    }
    
    /**
     * Add a JavaScript file
     * 
     * @param string $file Path to JavaScript file relative to public directory
     * @param bool $defer Whether to defer loading
     * @param bool $async Whether to load asynchronously
     */
    public static function addJs($file, $defer = false, $async = false)
    {
        self::$jsFiles[] = [
            'file' => $file,
            'defer' => $defer,
            'async' => $async
        ];
    }
    
    /**
     * Get HTML for CSS files
     * 
     * @return string HTML for CSS files
     */
    public static function getCssHtml()
    {
        if (empty(self::$cssFiles)) {
            return '';
        }
        
        $html = '';
        
        if (self::$combineCss) {
            // Combine CSS files
            $files = array_column(self::$cssFiles, 'file');
            $combinedFile = AssetOptimizer::combineCss($files);
            $html .= '<link rel="stylesheet" href="' . $combinedFile . '" media="all">' . PHP_EOL;
        } else {
            // Include individual CSS files
            foreach (self::$cssFiles as $css) {
                $file = $css['file'];
                $media = $css['media'];
                
                if (self::$minifyCss) {
                    $file = AssetOptimizer::minifyCss($file);
                }
                
                $html .= '<link rel="stylesheet" href="' . $file . '" media="' . $media . '">' . PHP_EOL;
            }
        }
        
        return $html;
    }
    
    /**
     * Get HTML for JavaScript files
     * 
     * @return string HTML for JavaScript files
     */
    public static function getJsHtml()
    {
        if (empty(self::$jsFiles)) {
            return '';
        }
        
        $html = '';
        
        if (self::$combineJs) {
            // Combine JavaScript files
            $files = array_column(self::$jsFiles, 'file');
            $combinedFile = AssetOptimizer::combineJs($files);
            $html .= '<script src="' . $combinedFile . '"></script>' . PHP_EOL;
        } else {
            // Include individual JavaScript files
            foreach (self::$jsFiles as $js) {
                $file = $js['file'];
                $defer = $js['defer'] ? ' defer' : '';
                $async = $js['async'] ? ' async' : '';
                
                if (self::$minifyJs) {
                    $file = AssetOptimizer::minifyJs($file);
                }
                
                $html .= '<script src="' . $file . '"' . $defer . $async . '></script>' . PHP_EOL;
            }
        }
        
        return $html;
    }
    
    /**
     * Get HTML for a lazy-loaded image
     * 
     * @param string $src Image source path
     * @param string $alt Alt text for the image
     * @param array $attributes Additional attributes for the img tag
     * @return string HTML for lazy-loaded image
     */
    public static function lazyImage($src, $alt = '', $attributes = [])
    {
        $src = ImageOptimizer::getImageWithFallback($src);
        return AssetOptimizer::lazyImage($src, $alt, $attributes);
    }
    
    /**
     * Get HTML for a responsive image with srcset
     * 
     * @param string $src Base image source path
     * @param array $sizes Array of sizes with width and path
     * @param string $alt Alt text for the image
     * @param array $attributes Additional attributes for the img tag
     * @return string HTML for responsive image
     */
    public static function responsiveImage($src, $sizes = [], $alt = '', $attributes = [])
    {
        $src = ImageOptimizer::getImageWithFallback($src);
        
        if (empty($sizes)) {
            // Generate responsive sizes if not provided
            $sizes = ImageOptimizer::createResponsiveImages($src);
        }
        
        return AssetOptimizer::responsiveImage($src, $sizes, $alt, $attributes);
    }
} 