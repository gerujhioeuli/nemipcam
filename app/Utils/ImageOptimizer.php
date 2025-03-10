<?php
namespace App\Utils;

/**
 * ImageOptimizer - Handles image optimization tasks
 * 
 * This class provides methods for:
 * - Image resizing
 * - Image compression
 * - Creating responsive image variants
 */
class ImageOptimizer
{
    /**
     * Base path for public assets
     */
    private static $basePath = '';
    
    /**
     * Cache directory for optimized images
     */
    private static $cacheDir = '';
    
    /**
     * Initialize the ImageOptimizer
     */
    public static function init($basePath = null)
    {
        self::$basePath = $basePath ?? $_SERVER['DOCUMENT_ROOT'];
        self::$cacheDir = self::$basePath . '/assets/cache/images';
        
        // Create cache directory if it doesn't exist
        if (!file_exists(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0755, true);
        }
    }
    
    /**
     * Resize and optimize an image
     * 
     * @param string $imagePath Path to the image relative to public directory
     * @param int $width Target width
     * @param int $height Target height (0 for proportional)
     * @param int $quality JPEG/PNG quality (0-100)
     * @return string Path to the optimized image
     */
    public static function resize($imagePath, $width, $height = 0, $quality = 80)
    {
        $fullPath = self::$basePath . '/' . $imagePath;
        
        if (!file_exists($fullPath)) {
            return $imagePath; // Return original path if file doesn't exist
        }
        
        $pathInfo = pathinfo($imagePath);
        $extension = strtolower($pathInfo['extension']);
        $filename = $pathInfo['filename'];
        
        // Create a unique filename for the resized image
        $newFilename = $filename . '-' . $width . 'x' . $height . '.' . $extension;
        $cachePath = self::$cacheDir . '/' . $newFilename;
        
        // Only resize if the cached file doesn't exist or the original is newer
        if (!file_exists($cachePath) || filemtime($fullPath) > filemtime($cachePath)) {
            // Get image dimensions
            list($origWidth, $origHeight) = getimagesize($fullPath);
            
            // Calculate new dimensions if height is 0 (proportional)
            if ($height == 0) {
                $height = floor($origHeight * ($width / $origWidth));
            }
            
            // Create image resource based on file type
            $sourceImage = null;
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $sourceImage = imagecreatefromjpeg($fullPath);
                    break;
                case 'png':
                    $sourceImage = imagecreatefrompng($fullPath);
                    break;
                case 'gif':
                    $sourceImage = imagecreatefromgif($fullPath);
                    break;
                default:
                    return $imagePath; // Unsupported format, return original
            }
            
            // Create a new true color image
            $destImage = imagecreatetruecolor($width, $height);
            
            // Preserve transparency for PNG and GIF
            if ($extension == 'png' || $extension == 'gif') {
                imagecolortransparent($destImage, imagecolorallocatealpha($destImage, 0, 0, 0, 127));
                imagealphablending($destImage, false);
                imagesavealpha($destImage, true);
            }
            
            // Resize the image
            imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);
            
            // Save the image
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($destImage, $cachePath, $quality);
                    break;
                case 'png':
                    // PNG quality is 0-9, convert from 0-100
                    $pngQuality = 9 - round(($quality / 100) * 9);
                    imagepng($destImage, $cachePath, $pngQuality);
                    break;
                case 'gif':
                    imagegif($destImage, $cachePath);
                    break;
            }
            
            // Free up memory
            imagedestroy($sourceImage);
            imagedestroy($destImage);
        }
        
        return 'assets/cache/images/' . $newFilename;
    }
    
    /**
     * Create responsive image variants
     * 
     * @param string $imagePath Path to the image relative to public directory
     * @param array $sizes Array of widths to generate
     * @param int $quality JPEG/PNG quality (0-100)
     * @return array Array of paths to the responsive images
     */
    public static function createResponsiveImages($imagePath, $sizes = [320, 640, 1024, 1920], $quality = 80)
    {
        $result = [];
        
        foreach ($sizes as $width) {
            $result[$width] = [
                'width' => $width,
                'path' => self::resize($imagePath, $width, 0, $quality)
            ];
        }
        
        return $result;
    }
    
    /**
     * Normalize image path
     * 
     * @param string $imagePath Path to the image
     * @return string Normalized path
     */
    public static function normalizePath($imagePath)
    {
        // Handle various image path formats
        if (strpos($imagePath, 'http') === 0 || strpos($imagePath, '//') === 0) {
            // External URL, return as is
            return $imagePath;
        }
        
        // Remove any ../ prefixes
        $imagePath = preg_replace('/^(\.\.\/)+/', '', $imagePath);
        
        // If path doesn't start with assets/images, add it
        if (strpos($imagePath, 'assets/images/') !== 0 && strpos($imagePath, 'assets/cache/images/') !== 0) {
            $imagePath = 'assets/images/' . $imagePath;
        }
        
        return $imagePath;
    }
    
    /**
     * Check if an image exists
     * 
     * @param string $imagePath Path to the image
     * @return bool True if the image exists
     */
    public static function imageExists($imagePath)
    {
        $normalizedPath = self::normalizePath($imagePath);
        return file_exists(self::$basePath . '/' . $normalizedPath);
    }
    
    /**
     * Get a fallback image if the original doesn't exist
     * 
     * @param string $imagePath Path to the image
     * @param string $fallbackPath Path to the fallback image
     * @return string Path to the image or fallback
     */
    public static function getImageWithFallback($imagePath, $fallbackPath = 'assets/images/placeholder.jpg')
    {
        $normalizedPath = self::normalizePath($imagePath);
        
        if (self::imageExists($normalizedPath)) {
            return $normalizedPath;
        }
        
        return $fallbackPath;
    }
} 