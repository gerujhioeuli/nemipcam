<?php
namespace App\Utils;

/**
 * AssetOptimizer - Handles asset optimization tasks
 * 
 * This class provides methods for:
 * - CSS minification
 * - JavaScript minification
 * - Image optimization
 * - Asset versioning
 */
class AssetOptimizer
{
    /**
     * Base path for public assets
     */
    private static $basePath = '';
    
    /**
     * Cache directory for optimized assets
     */
    private static $cacheDir = '';
    
    /**
     * Initialize the AssetOptimizer
     */
    public static function init($basePath = null)
    {
        self::$basePath = $basePath ?? $_SERVER['DOCUMENT_ROOT'];
        self::$cacheDir = self::$basePath . '/assets/cache';
        
        // Create cache directory if it doesn't exist
        if (!file_exists(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0755, true);
        }
    }
    
    /**
     * Minify CSS file
     * 
     * @param string $file Path to CSS file relative to public directory
     * @return string Path to minified CSS file
     */
    public static function minifyCss($file)
    {
        $filePath = self::$basePath . '/' . $file;
        $fileName = basename($file);
        $fileInfo = pathinfo($fileName);
        $minFileName = $fileInfo['filename'] . '.min.' . $fileInfo['extension'];
        $minFilePath = self::$cacheDir . '/' . $minFileName;
        
        // Only minify if the original file is newer than the minified file
        if (!file_exists($minFilePath) || filemtime($filePath) > filemtime($minFilePath)) {
            $css = file_get_contents($filePath);
            
            // Basic CSS minification
            $css = preg_replace('/\/\*(?!!)[\s\S]*?\*\//', '', $css); // Remove comments
            $css = preg_replace('/\s+/', ' ', $css); // Replace multiple spaces with single space
            $css = str_replace(': ', ':', $css); // Remove space after colon
            $css = str_replace(' {', '{', $css); // Remove space before opening brace
            $css = str_replace('{ ', '{', $css); // Remove space after opening brace
            $css = str_replace('} ', '}', $css); // Remove space after closing brace
            $css = str_replace('; ', ';', $css); // Remove space after semicolon
            $css = str_replace(', ', ',', $css); // Remove space after comma
            $css = str_replace(' > ', '>', $css); // Remove spaces around child selector
            $css = str_replace(' + ', '+', $css); // Remove spaces around adjacent sibling selector
            $css = str_replace(' ~ ', '~', $css); // Remove spaces around general sibling selector
            
            file_put_contents($minFilePath, $css);
        }
        
        return 'assets/cache/' . $minFileName . '?v=' . filemtime($minFilePath);
    }
    
    /**
     * Minify JavaScript file
     * 
     * @param string $file Path to JavaScript file relative to public directory
     * @return string Path to minified JavaScript file
     */
    public static function minifyJs($file)
    {
        $filePath = self::$basePath . '/' . $file;
        $fileName = basename($file);
        $fileInfo = pathinfo($fileName);
        $minFileName = $fileInfo['filename'] . '.min.' . $fileInfo['extension'];
        $minFilePath = self::$cacheDir . '/' . $minFileName;
        
        // Only minify if the original file is newer than the minified file
        if (!file_exists($minFilePath) || filemtime($filePath) > filemtime($minFilePath)) {
            $js = file_get_contents($filePath);
            
            // Basic JS minification
            $js = preg_replace('/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/', '', $js); // Remove comments
            $js = preg_replace('/\s+/', ' ', $js); // Replace multiple spaces with single space
            $js = preg_replace('/\s*([{}:;,=\+\-\*\/])\s*/', '$1', $js); // Remove spaces around operators
            
            file_put_contents($minFilePath, $js);
        }
        
        return 'assets/cache/' . $minFileName . '?v=' . filemtime($minFilePath);
    }
    
    /**
     * Combine multiple CSS files into one
     * 
     * @param array $files Array of CSS file paths relative to public directory
     * @param string $outputName Name for the combined file
     * @return string Path to combined CSS file
     */
    public static function combineCss(array $files, $outputName = 'combined.css')
    {
        $outputPath = self::$cacheDir . '/' . $outputName;
        $lastModified = 0;
        
        // Check if any of the source files are newer than the combined file
        foreach ($files as $file) {
            $filePath = self::$basePath . '/' . $file;
            if (file_exists($filePath)) {
                $lastModified = max($lastModified, filemtime($filePath));
            }
        }
        
        // Only combine if the combined file doesn't exist or any source file is newer
        if (!file_exists($outputPath) || $lastModified > filemtime($outputPath)) {
            $combined = '';
            
            foreach ($files as $file) {
                $filePath = self::$basePath . '/' . $file;
                if (file_exists($filePath)) {
                    $css = file_get_contents($filePath);
                    
                    // Fix relative URLs in CSS
                    $fileDir = dirname($file);
                    $css = preg_replace_callback('/url\([\'"]?([^\'")]+)[\'"]?\)/', function($matches) use ($fileDir) {
                        $url = $matches[1];
                        if (strpos($url, 'data:') === 0 || strpos($url, 'http') === 0 || strpos($url, '//') === 0) {
                            return "url({$url})";
                        }
                        
                        return "url(../{$fileDir}/{$url})";
                    }, $css);
                    
                    $combined .= "/* {$file} */\n" . $css . "\n";
                }
            }
            
            // Basic minification
            $combined = preg_replace('/\/\*(?!!)[\s\S]*?\*\//', '', $combined); // Remove comments except for file markers
            $combined = preg_replace('/\s+/', ' ', $combined); // Replace multiple spaces with single space
            $combined = str_replace(': ', ':', $combined); // Remove space after colon
            $combined = str_replace(' {', '{', $combined); // Remove space before opening brace
            $combined = str_replace('{ ', '{', $combined); // Remove space after opening brace
            $combined = str_replace('} ', '}', $combined); // Remove space after closing brace
            $combined = str_replace('; ', ';', $combined); // Remove space after semicolon
            $combined = str_replace(', ', ',', $combined); // Remove space after comma
            
            file_put_contents($outputPath, $combined);
        }
        
        return 'assets/cache/' . $outputName . '?v=' . filemtime($outputPath);
    }
    
    /**
     * Combine multiple JavaScript files into one
     * 
     * @param array $files Array of JavaScript file paths relative to public directory
     * @param string $outputName Name for the combined file
     * @return string Path to combined JavaScript file
     */
    public static function combineJs(array $files, $outputName = 'combined.js')
    {
        $outputPath = self::$cacheDir . '/' . $outputName;
        $lastModified = 0;
        
        // Check if any of the source files are newer than the combined file
        foreach ($files as $file) {
            $filePath = self::$basePath . '/' . $file;
            if (file_exists($filePath)) {
                $lastModified = max($lastModified, filemtime($filePath));
            }
        }
        
        // Only combine if the combined file doesn't exist or any source file is newer
        if (!file_exists($outputPath) || $lastModified > filemtime($outputPath)) {
            $combined = '';
            
            foreach ($files as $file) {
                $filePath = self::$basePath . '/' . $file;
                if (file_exists($filePath)) {
                    $js = file_get_contents($filePath);
                    $combined .= "/* {$file} */\n" . $js . ";\n"; // Add semicolon to prevent issues
                }
            }
            
            // Basic minification
            $combined = preg_replace('/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/', '', $combined); // Remove comments
            $combined = preg_replace('/\s+/', ' ', $combined); // Replace multiple spaces with single space
            $combined = preg_replace('/\s*([{}:;,=\+\-\*\/])\s*/', '$1', $combined); // Remove spaces around operators
            
            file_put_contents($outputPath, $combined);
        }
        
        return 'assets/cache/' . $outputName . '?v=' . filemtime($outputPath);
    }
    
    /**
     * Get HTML for lazy loading an image
     * 
     * @param string $src Image source path
     * @param string $alt Alt text for the image
     * @param array $attributes Additional attributes for the img tag
     * @return string HTML for lazy-loaded image
     */
    public static function lazyImage($src, $alt = '', $attributes = [])
    {
        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= " {$key}=\"{$value}\"";
        }
        
        return "<img data-src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\" class=\"lazy\"{$attributesStr}>";
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
        $attributesStr = '';
        foreach ($attributes as $key => $value) {
            $attributesStr .= " {$key}=\"{$value}\"";
        }
        
        $srcset = '';
        $sizeStr = '';
        
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                $srcset .= "{$size['path']} {$size['width']}w, ";
                $sizeStr .= "(max-width: {$size['width']}px) {$size['width']}px, ";
            }
            $srcset = rtrim($srcset, ', ');
            $sizeStr = rtrim($sizeStr, ', ');
            
            return "<img src=\"{$src}\" srcset=\"{$srcset}\" sizes=\"{$sizeStr}\" alt=\"{$alt}\" loading=\"lazy\"{$attributesStr}>";
        }
        
        return "<img src=\"{$src}\" alt=\"{$alt}\" loading=\"lazy\"{$attributesStr}>";
    }
} 