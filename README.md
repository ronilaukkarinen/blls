# Blls.io

**Blls** (bills.io as in _bills I owe_) is a web application for managing and tracking your bills and payments. Keep tabs on what you owe, what you've paid, and maintain a clear financial history.

## Features

* Track both paid and unpaid bills
* Organize bills by categories and due dates
* Set up payment reminders
* View payment history and trends
* Generate financial reports
* Multi-user support with role-based access
* Secure authentication and data encryption
* Mobile-friendly responsive interface
* Export data to CSV/PDF formats
* Customizable bill categories and tags
* Recurring bill management
* Email notifications for due dates
* Multi-currency support
* Dark/Light theme options

## Requirements

* PHP 8.1 or higher
* Node.js 16+ and Yarn package manager
* MySQL 5.7+ or MariaDB 10.3+
* Composer 2.0+
* Web server (Apache/Nginx)
* SSL certificate (recommended for production)
* SendGrid account for email notifications
* Minimum 512MB RAM
* 1GB free disk space

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/ronilaukkarinen/blls
   cd blls
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   yarn install
   ```

4. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Set up database:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. Build frontend assets:
   ```bash
   yarn build
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Configuration

1. Update `.env` file with your database credentials
2. Configure SendGrid API key for email notifications
3. Set up your application URL
4. Configure timezone settings

## Testing

Run the test suite:

```bash
php artisan test
```

## License

This project is proprietary software. See the [LICENSE](LICENSE) file for details.


