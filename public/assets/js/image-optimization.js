/**
 * Image Optimization
 * 
 * This script provides functions for image optimization:
 * - Lazy loading images
 * - Responsive image loading
 * - Image placeholder handling
 */

(function() {
    'use strict';
    
    /**
     * Initialize image optimization
     */
    function init() {
        // Initialize lazy loading
        initLazyLoading();
        
        // Initialize responsive images
        initResponsiveImages();
    }
    
    /**
     * Initialize lazy loading
     */
    function initLazyLoading() {
        // Check if Intersection Observer is supported
        if ('IntersectionObserver' in window) {
            const lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const lazyImage = entry.target;
                        
                        // Set the src attribute to the data-src value
                        if (lazyImage.dataset.src) {
                            lazyImage.src = lazyImage.dataset.src;
                            lazyImage.removeAttribute('data-src');
                        }
                        
                        // Set the srcset attribute to the data-srcset value if it exists
                        if (lazyImage.dataset.srcset) {
                            lazyImage.srcset = lazyImage.dataset.srcset;
                            lazyImage.removeAttribute('data-srcset');
                        }
                        
                        lazyImage.classList.remove('lazy');
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });
            
            // Observe all images with the 'lazy' class
            document.querySelectorAll('img.lazy').forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        } else {
            // Fallback for browsers that don't support Intersection Observer
            let lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));
            let active = false;
            
            const lazyLoad = function() {
                if (active === false) {
                    active = true;
                    
                    setTimeout(function() {
                        lazyImages.forEach(function(lazyImage) {
                            if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== 'none') {
                                if (lazyImage.dataset.src) {
                                    lazyImage.src = lazyImage.dataset.src;
                                    lazyImage.removeAttribute('data-src');
                                }
                                
                                if (lazyImage.dataset.srcset) {
                                    lazyImage.srcset = lazyImage.dataset.srcset;
                                    lazyImage.removeAttribute('data-srcset');
                                }
                                
                                lazyImage.classList.remove('lazy');
                                
                                lazyImages = lazyImages.filter(function(image) {
                                    return image !== lazyImage;
                                });
                                
                                if (lazyImages.length === 0) {
                                    document.removeEventListener('scroll', lazyLoad);
                                    window.removeEventListener('resize', lazyLoad);
                                    window.removeEventListener('orientationchange', lazyLoad);
                                }
                            }
                        });
                        
                        active = false;
                    }, 200);
                }
            };
            
            // Add event listeners for scroll, resize, and orientation change
            document.addEventListener('scroll', lazyLoad);
            window.addEventListener('resize', lazyLoad);
            window.addEventListener('orientationchange', lazyLoad);
            
            // Initial load
            lazyLoad();
        }
    }
    
    /**
     * Initialize responsive images
     */
    function initResponsiveImages() {
        // Add event listener for window resize
        window.addEventListener('resize', function() {
            // Update responsive images based on screen size
            updateResponsiveImages();
        });
        
        // Initial update
        updateResponsiveImages();
    }
    
    /**
     * Update responsive images based on screen size
     */
    function updateResponsiveImages() {
        // Get all responsive images
        const responsiveImages = document.querySelectorAll('img[srcset]');
        
        // Update each responsive image
        responsiveImages.forEach(function(image) {
            // Get the srcset attribute
            const srcset = image.getAttribute('srcset');
            
            // If srcset is not empty, update the image
            if (srcset) {
                // Get the current window width
                const windowWidth = window.innerWidth;
                
                // Parse the srcset attribute
                const sources = srcset.split(',').map(function(source) {
                    const parts = source.trim().split(' ');
                    return {
                        url: parts[0],
                        width: parseInt(parts[1])
                    };
                });
                
                // Sort sources by width
                sources.sort(function(a, b) {
                    return a.width - b.width;
                });
                
                // Find the appropriate source
                let selectedSource = sources[0];
                for (let i = 0; i < sources.length; i++) {
                    if (sources[i].width >= windowWidth) {
                        selectedSource = sources[i];
                        break;
                    }
                    
                    // If this is the last source and it's smaller than the window width,
                    // use it anyway
                    if (i === sources.length - 1) {
                        selectedSource = sources[i];
                    }
                }
                
                // Update the image source
                if (selectedSource && selectedSource.url) {
                    image.src = selectedSource.url;
                }
            }
        });
    }
    
    // Initialize when the DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})(); 