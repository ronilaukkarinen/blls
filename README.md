# Blls.io

**Blls** (bills.io as in _bills I owe_) is a web application for managing and tracking your bills and payments. Keep tabs on what you owe, what you've paid, and maintain a clear financial history.

> [!NOTE] Please note
> This repository is currently not functional due to outdated and unresolved dependencies. The project requires significant updates to dependencies and compatibility fixes before it can be used. Use at your own risk.

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

## Installation on macOS

Clone the repository.

```bash
git clone https://github.com/ronilaukkarinen/blls
cd blls
```

Install PHP dependencies.

```bash
composer install
```

Install JavaScript dependencies.

```bash
nvm install
nvm use
yarn install
```

Configure environment.

```bash
cp .env.example .env
php artisan key:generate
```

Set up database.

```bash
php artisan migrate
php artisan db:seed
```

Build frontend assets.

```bash
yarn build
```

Start the development server.

```bash
php artisan serve
```

## Configuration

1. Update `.env` file with your database credentials
2. Configure SendGrid API key for email notifications
3. Set up your application URL
4. Configure timezone settings

## Testing

Run the test suite.

```bash
php artisan test
```

## License

This project is proprietary software. See the [LICENSE](LICENSE) file for details.


