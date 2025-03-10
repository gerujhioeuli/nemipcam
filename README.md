# Nem Ip Cam Website

A modern e-commerce website for selling Ajax security equipment, built with PHP using an MVC architecture.

## Features

- Modern MVC architecture
- Responsive design
- Product catalog with categories
- Search functionality
- Image optimization
- Browser caching
- Performance optimizations
- Security enhancements

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled
- Composer for dependency management

## Installation

1. Clone the repository:
```bash
git clone https://github.com/gerujhioeuli/nemipcam.git
cd nemipcam
```

2. Install dependencies:
```bash
composer install
```

3. Create a MySQL database and import the schema:
```bash
mysql -u root -p
CREATE DATABASE eriksen_websiteajax;
exit;
mysql -u root -p eriksen_websiteajax < eriksen_website_mysql_service_one_com.sql
```

4. Configure your web server:
   - Set document root to the `public` directory
   - Ensure mod_rewrite is enabled
   - Make sure .htaccess files are allowed

5. Copy the example environment file and configure it:
```bash
cp .env.example .env
```
Edit `.env` with your database credentials and other settings.

## Directory Structure

- `/app` - Application core files (models, views, controllers)
- `/config` - Configuration files
- `/database` - Database migrations and seeds
- `/public` - Publicly accessible files
- `/vendor` - Composer dependencies
- `/assets` - CSS, JavaScript, and images
- `/docs` - Documentation files

## Development

1. Start the development server:
```bash
php -S localhost:8000 -t public
```

2. Visit http://localhost:8000 in your browser

## Testing

Run the test suite:
```bash
composer test
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## Security

If you discover any security related issues, please email [contact email] instead of using the issue tracker.

## Credits

- [Your Name] - Developer
- [Other Contributors]

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details. 