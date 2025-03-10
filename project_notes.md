# Project Notes for Website Enhancement

## Project Overview
- E-commerce website selling Ajax security equipment
- Moving from traditional PHP structure to MVC architecture
- Database already imported from production (one.com)

## Current Environment Setup
1. Local Development:
   - XAMPP installed (Apache, MySQL, PHP)
   - Composer installed and configured
   - Database imported and working
   - Base MVC structure implemented

2. Database Details:
   - Name: eriksen_websiteajax
   - Host (local): localhost
   - Username: root
   - Password: (empty)
   - Production host: eriksen.website.mysql.service.one.com

3. Important Files:
   - `/config/database.php` - Database configuration
   - `/app/models/Model.php` - Base model class with CRUD operations
   - `/app/controllers/Controller.php` - Base controller with view handling
   - `/app/Router.php` - URL routing system
   - `/app/views/layouts/main.php` - Main layout template
   - `/public/assets/css/*.css` - CSS stylesheets

## Frontend Structure
1. Component-Based CSS:
   - Topbar component (`/public/assets/css/components/topbar.css`)
   - Header component (`/public/assets/css/components/header.css`)
   - Footer component (`/public/assets/css/components/footer.css`)
   - Mobile-responsive design implemented
   - Font Awesome integration for icons

2. Layout System:
   - Main layout template with proper meta tags
   - Responsive container system
   - Modular partial views for reusable components
   - Mobile-first approach with media queries

## Database Structure
Key tables:
- `products` - Main products table
- `kategorier` - Categories
- Product-specific tables:
  - Alarmpakker
  - Alarmpaneler
  - Betjening
  - Sensorer
  - Sirener
  - Videoovervågning
  - (and more)

## Database Optimization (Phase 2, Completed March 11, 2024)
1. Database Optimizer Implementation:
   - Created `DatabaseOptimizer` class (`app/database/DatabaseOptimizer.php`)
   - Implemented singleton pattern for global access
   - Added query caching with configurable TTL
   - Implemented connection pooling to reduce overhead
   - Added slow query logging for performance analysis
   - Integrated with the base Model class

2. Database Audit System:
   - Created `DatabaseAudit` class (`app/database/DatabaseAudit.php`)
   - Analyzes database structure for optimization opportunities
   - Identifies missing indexes, inefficient column types, and redundant tables
   - Generates SQL statements for implementing optimizations
   - Audit results saved to JSON files in the `logs` directory

3. Model Class Updates:
   - Updated to use the DatabaseOptimizer for all database operations
   - Added automatic connection pooling
   - Implemented query caching for read operations
   - Added cache invalidation for write operations
   - Improved parameter binding for better security

4. Testing Scripts:
   - `database/run_audit.php` - Run database structure audit
   - `database/connection_pool.php` - Test connection pooling
   - `database/query_cache.php` - Test query caching
   - `database/optimize_queries.php` - Analyze and optimize queries

5. Recommendations:
   - Consider consolidating product-specific tables into a single `products` table
   - Add indexes to foreign key columns and frequently queried fields
   - Optimize column types for better performance
   - Use specific column names instead of `SELECT *` in queries

6. Documentation:
   - `database/README.md` - Usage instructions and implementation details
   - `database/SUMMARY.md` - Summary of completed work and next steps

## Security Implementation (Phase 3)
1. Authentication System:
   - User authentication with email/password
   - Role-based authorization (admin, user)
   - Permission-based access control
   - Secure session handling
   - Password hashing with bcrypt

2. Security Features:
   - Input validation framework (`Security::validateInput()`)
   - Output escaping for XSS prevention (`Security::sanitizeInput()`)
   - CSRF protection (`Security::generateCsrfToken()`, `Security::validateCsrfToken()`)
   - Security headers (XSS Protection, Content Security Policy, etc.)

3. Middleware System:
   - Authentication middleware
   - CSRF middleware
   - Role-based authorization middleware
   - Permission-based authorization middleware
   - Security headers middleware

4. Database Tables:
   - `users` - User accounts with roles
   - `permissions` - Available permissions
   - `user_permissions` - User-permission relationships
   - Default admin user: admin@example.com / password

5. Authentication Views:
   - Login form: `/login`
   - Registration form: `/register`
   - Custom CSS for auth pages: `/assets/css/auth.css`

6. Usage Examples:
   ```php
   // Validate input
   $rules = [
       'email' => ['required' => true, 'type' => 'email'],
       'password' => ['required' => true, 'minLength' => 8]
   ];
   $errors = Security::validateInput($_POST, $rules);
   
   // Protect against CSRF
   // In form:
   <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
   // In controller:
   if (!Security::validateCsrfToken($_POST['csrf_token'])) {
       // Invalid token
   }
   
   // Check authentication
   if (Auth::check()) {
       // User is logged in
   }
   
   // Check roles
   if (Auth::hasRole('admin')) {
       // User is an admin
   }
   
   // Check permissions
   if (Auth::hasPermission('edit_products')) {
       // User can edit products
   }
   ```

7. Setup Instructions:
   - Run the database setup script: `php database/setup_auth.php`
   - This will create the necessary tables and default admin user
   - Default login: admin@example.com / password

## Server-Side Optimization (Phase 5, 1, Completed March 15, 2024)
1. PHP OpCache Implementation:
   - Created `PhpOptimizer` class (`app/Utils/PhpOptimizer.php`)
   - Implemented OpCache configuration and management
   - Added OpCache status monitoring
   - Configured optimal OpCache settings
   - Integrated with bootstrap process

2. Server-Side Caching System:
   - Created `ServerOptimizer` class (`app/Utils/ServerOptimizer.php`)
   - Implemented in-memory and file-based caching
   - Added page caching for full-page output
   - Implemented cache expiration and invalidation
   - Added helper functions for easy caching

3. PHP Configuration Optimization:
   - Created `php_optimization.php` configuration file
   - Optimized memory and execution settings
   - Configured error handling and logging
   - Optimized session settings
   - Implemented realpath cache optimization

4. Request/Response Compression:
   - Enhanced `.htaccess` with compression directives
   - Implemented zlib output compression
   - Added support for pre-compressed content
   - Configured optimal compression level
   - Added content type handling for compressed files

5. Testing and Documentation:
   - Created `server_optimization_test.php` script
   - Added comprehensive documentation in `docs/server_optimization.md`
   - Updated bootstrap process to initialize optimizations
   - Added helper functions for caching operations
   - Implemented performance monitoring

6. Usage Examples:
   ```php
   // Cache data
   cacheData('my_key', $data, 300); // Cache for 5 minutes
   
   // Get cached data
   $data = getCachedData('my_key');
   
   // Cache a page
   $cachedPage = pageCache('/my-page', 300);
   if ($cachedPage === false) {
       // Page not cached, generate content
       // ...
       
       // Save page to cache
       savePageCache('/my-page', 300);
   }
   ```

## Image Path Handling (IMPORTANT)
1. Directory Structure:
   - The website uses an MVC architecture with a `public` directory as the web root
   - All publicly accessible files must be in the `public` directory
   - Images are stored in `public/assets/images/`

2. Image Path Fix (March 10, 2024):
   - Images were previously stored in `website/assets/images/` (outside public directory)
   - This caused images not to display on the website
   - Solution: All images were copied to `public/assets/images/` to make them web-accessible
   - The views handle various image path formats:
     - Paths starting with `assets/images/`
     - Paths with `../` prefixes
     - Simple filenames

3. Database Image Paths:
   - Image paths in the database are stored in various formats:
     - Some as `../../assets/images/filename.png`
     - Some as just filenames
   - The views handle these different formats automatically
   - When adding new images, place them in `public/assets/images/`

4. Image Path Handling in Views:
   - Views use a standardized approach to handle image paths
   - Path normalization code is included in all product-related views
   - Fallback images are provided for missing images

## Frontend Performance (Phase 5, 2, Completed March 16, 2024)
1. Routing System Fix:
   - Fixed 404 errors when clicking on categories and products
   - Updated Router.php to handle dynamic parameters in routes
   - Added redirects in .htaccess for old URL structure
   - Updated links in index.php to point to new MVC routes
   - Created test script to verify routing functionality
   - Ensured backward compatibility with old URLs

2. Browser Caching Implementation:
   - Enhanced .htaccess with cache control headers
   - Implemented browser caching for static assets
   - Set appropriate cache durations for different file types
   - Added cache control headers for HTML and PHP files
   - Implemented ETags for cache validation
   - Added Vary headers for proper cache handling

3. Critical Rendering Path Optimization:
   - Moved CSS to the head section
   - Deferred non-critical JavaScript
   - Inlined critical CSS for above-the-fold content
   - Reduced render-blocking resources
   - Implemented async loading for non-critical resources
   - Optimized font loading

4. Server Response Time Reduction:
   - Implemented database query caching
   - Added page caching for frequently accessed pages
   - Optimized PHP configuration
   - Reduced unnecessary database queries
   - Implemented connection pooling
   - Added server-side caching

5. HTTP Request Minimization:
   - Combined multiple CSS files
   - Combined multiple JavaScript files
   - Implemented CSS and JavaScript minification
   - Used CSS sprites for icons
   - Implemented lazy loading for images
   - Reduced third-party requests

6. Testing and Documentation:
   - Created test_routes.php to verify routing functionality
   - Updated enhancement_tracker.md to reflect progress
   - Added detailed documentation in project_notes.md
   - Created route_test_results.html with test results
   - Updated .htaccess with comments explaining redirects
   - Documented the changes in the Router class

7. View Fixes (March 16, 2024):
   - Fixed category view errors related to undefined array keys
   - Updated views to handle both 'navn' and 'name' fields for categories
   - Added proper fallbacks for all category and product data
   - Created default images for categories and products
   - Improved image path handling in all views
   - Enhanced error handling in views to prevent warnings

## Completed Work
1. Development Environment:
   - ✅ Local environment setup
   - ✅ Database imported
   - ✅ Composer configuration
   - ✅ Basic MVC structure

2. Base Classes Created:
   - ✅ Model.php with CRUD operations
   - ✅ Controller.php with view rendering
   - ✅ Router.php for URL handling

3. Frontend Modernization:
   - ✅ Component-based CSS structure
   - ✅ Responsive design implementation
   - ✅ Font Awesome integration
   - ✅ Mobile navigation
   - ✅ Modular layout system

4. Security Implementation:
   - ✅ Input validation framework
   - ✅ Output escaping
   - ✅ CSRF protection
   - ✅ Authentication system
   - ✅ Role-based authorization
   - ✅ Security headers

5. Image Display:
   - ✅ Fixed image path handling
   - ✅ Copied images to public directory
   - ✅ Implemented fallback images

6. Database Optimization:
   - ✅ Database audit system
   - ✅ Query caching implementation
   - ✅ Connection pooling
   - ✅ Query optimization
   - ✅ Model class integration

7. Server-Side Optimization:
   - ✅ PHP OpCache implementation
   - ✅ Server-side caching system
   - ✅ PHP configuration optimization
   - ✅ Request/response compression
   - ✅ Performance monitoring

8. Frontend Performance:
   - ✅ Routing system fix
   - ✅ Browser caching implementation
   - ✅ Critical rendering path optimization
   - ✅ Server response time reduction
   - ✅ HTTP request minimization

## Next Steps
1. Code Quality & Documentation:
   - Implement PSR standards
   - Add code formatting rules
   - Setup automated linting
   - Refactor for consistency

2. Create specific models for each table:
   - Product model
   - Category model
   - Specific product type models

## Important Considerations
1. Security Focus:
   - Website sells security equipment
   - Handle customer data with care
   - Implement proper validation

2. Database Structure:
   - Multiple product tables exist
   - Consider consolidating tables in future
   - Maintain backwards compatibility

3. SEO Requirements:
   - Maintain current URL structure
   - Preserve existing meta data
   - Keep language specific content (Danish)

4. Image Handling:
   - Always place new images in `public/assets/images/`
   - Use consistent naming conventions
   - Consider implementing image optimization

## Testing
- Test database connections with test.php
- Verify product listings work
- Check category navigation
- Ensure all product types are accessible
- Test responsive design on various devices
- Test authentication system with different roles
- Test server-side optimization with server_optimization_test.php

## Contacts
- Production Database: one.com hosting
- Project Tracking: enhancement_tracker.txt
- Database Backup: eriksen_website_mysql_service_one_com.sql

## Common Issues & Solutions
1. If database connection fails:
   - Verify MySQL is running in XAMPP
   - Check database name is correct
   - Ensure proper credentials in config

2. If autoloading fails:
   - Run `composer dump-autoload`
   - Check namespace declarations
   - Verify class file locations

3. If authentication doesn't work:
   - Ensure session is started
   - Check if auth tables are created
   - Verify user exists in database

4. If images don't display:
   - Ensure images are in `public/assets/images/`
   - Check image path handling in views
   - Verify image filenames match database records

5. If database optimization features don't work:
   - Ensure the DatabaseOptimizer class is properly autoloaded
   - Check that the logs directory exists and is writable
   - Verify database connection parameters in config/database.php

6. If server-side optimization features don't work:
   - Ensure the ServerOptimizer and PhpOptimizer classes are properly autoloaded
   - Check that the logs/cache directory exists and is writable
   - Verify PHP has the OpCache extension installed
   - Check Apache has the mod_deflate and mod_expires modules enabled

## Development Guidelines
1. Follow PSR-4 autoloading standards
2. Maintain PHP 7.4+ compatibility
3. Document all major changes
4. Update enhancement tracker as you progress
5. Use component-based approach for CSS
6. Maintain mobile-first responsive design
7. Always validate and sanitize user input
8. Use CSRF tokens for all forms
9. Apply proper authorization checks
10. Place all public assets in the public directory
11. Use the DatabaseOptimizer for all database operations
12. Check query cache for frequently accessed data
13. Use the ServerOptimizer for caching frequently accessed data
14. Implement page caching for static or semi-static pages 