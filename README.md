# Blls.io

**Blls** (bills.io as in _bills I owe_) is a web application for managing and tracking your bills and payments. Keep tabs on what you owe, what you've paid, and maintain a clear financial history.

> [!NOTE]
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

# Project Setup

## Prerequisites

### macOS
1. Install Homebrew if not already installed:
   ```bash
   /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
   ```

2. Install nvm (Node Version Manager):
   ```bash
   # Install nvm if you don't have it
   curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
   ```

3. Install Python 2.7 (required for some dependencies):
   ```bash
   brew install pyenv
   pyenv install 2.7.18
   pyenv global 2.7.18
   ```

### Linux (Ubuntu/Debian)
1. Install nvm:
   ```bash
   # Install nvm
   curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
   source ~/.bashrc
   ```

2. Install Python 2.7 and build essentials:
   ```bash
   sudo apt-get update
   sudo apt-get install -y python2.7 build-essential
   ```

## Installation

1. Clone the repository:
   ```bash
   git clone [repository-url]
   cd [project-directory]
   ```

2. Set up Node.js using nvm:
   ```bash
   # Create .nvmrc file
   echo "16.20.2" > .nvmrc
   
   # Install and use the correct Node version
   nvm install
   nvm use
   ```

3. Install Yarn if you don't have it:
   ```bash
   npm install -g yarn
   ```

4. Create necessary configuration files:
   ```bash
   # Create .npmrc
   echo "legacy-peer-deps=true
   package-lock=false
   node-sass=npm:sass@latest" > .npmrc
   ```

5. Install dependencies:
   ```bash
   yarn install
   ```

## Development

1. Start the development server:
   ```bash
   gulp watch
   ```

2. Build for production:
   ```bash
   gulp build
   ```

## Troubleshooting

If you encounter any issues during installation:

1. Clean the environment:
   ```bash
   rm -rf node_modules
   rm yarn.lock
   yarn cache clean
   ```

2. Make sure you're using the correct Node.js version:
   ```bash
   nvm use  # This will use the version specified in .nvmrc
   node -v  # Should show v16.20.2
   ```

3. Reinstall dependencies:
   ```bash
   yarn install
   ```

## Notes

- The project uses Gulp for task automation
- Sass compilation is handled by dart-sass
- Node.js version 16.20.2 is required for compatibility
- Python 2.7 is required for some dependencies
