/**
 * Lazy Loading for Images
 * 
 * This script handles lazy loading of images to improve page load performance.
 * It uses the Intersection Observer API when available, with a fallback for older browsers.
 */

(function() {
    'use strict';
    
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
})(); 