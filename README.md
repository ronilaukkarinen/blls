# Blls.io

[![Latest Release](https://img.shields.io/github/v/release/ronilaukkarinen/blls?include_prereleases)](https://github.com/ronilaukkarinen/blls/releases)
[![License: GPL-3.0](https://img.shields.io/badge/License-GPL--3.0-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://www.php.net)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![Node](https://img.shields.io/badge/Node-16.x-green.svg)](https://nodejs.org)
[![Build Status](https://img.shields.io/github/actions/workflow/status/ronilaukkarinen/blls/ci.yml?branch=main)](https://github.com/ronilaukkarinen/blls/actions)

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
* Mailgun account for email notifications
* Minimum 512MB RAM
* 1GB free disk space

## Installation

Clone the repository.

```bash
git clone https://github.com/ronilaukkarinen/blls
cd blls
```

Install PHP dependencies.

```bash
composer install
composer require laravel/legacy-factories --dev
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

Set up database. Create a new database and run the migrations.

```bash
php artisan migrate:reset
php artisan migrate
composer dump-autoload
php artisan db:seed
```

Build frontend assets.

```bash
npm install gulp@4.0.2 -g
gulp build
```

Cache config.

```bash
php artisan config:cache
```

Start the development server.

```bash
php artisan serve:dev
```

Open localhost:3005 to start developing.

Register a new user and check the email from the log file `storage/logs/laravel.log`.

## Installing in production

1. Clone and set up the repository
```bash
git clone https://github.com/ronilaukkarinen/blls
cd blls
composer install --no-dev --optimize-autoloader
```

2. Configure environment and permissions
```bash
cp .env.example .env
php artisan key:generate
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

3. Set up your web server
- Configure Nginx/Apache to point to the `/public` directory
- Enable and configure PHP-FPM
- Set up SSL certificate (recommended: Let's Encrypt)

4. Install and build frontend assets
```bash
nvm install
nvm use
yarn install
gulp build --production
```

5. Set up the database
```bash
php artisan migrate --force
php artisan db:seed --force
```

6. Configure cache and optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

7. Set up task scheduler in crontab
```bash
* * * * * cd /path/to/blls && php artisan schedule:run >> /dev/null 2>&1
```

8. Configure supervisor for queue workers (if using queues)
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start blls-worker:*
```

### Email configuration for production

1. Update `.env` file with your database credentials
2. Set up Mailgun:
   - Create a Mailgun account at https://mailgun.com
   - Add and verify your domain
   - Copy your API key from Mailgun dashboard
   - Update MAILGUN_* variables in .env
3. Set up your application URL
4. Configure timezone settings

## Todo

[ ] Add dark mode
[ ] Add screenshots
[ ] Release 1.0
[ ] Improve accessibility: Change plus icon spans to buttons
[ ] Improve accessibility: Add close button to modals