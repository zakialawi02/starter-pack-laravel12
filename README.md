# StarterPack Laravel

Welcome to the Laravel 12 Starter Pack! This repository provides a solid foundation for building robust and scalable web applications using Laravel 12.

A comprehensive Laravel starter template with essential features and best practices built-in (Laravel 12 + blade + tailwindcss + Basic Auth).

## Table of Contents

-   [Features](#features)
-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage](#usage)
-   [Project Structure](#project-structure)
-   [Development](#development)
-   [Testing](#testing)
-   [Deployment](#deployment)
-   [Contributing](#contributing)
-   [License](#license)
-   [Support](#Support)

## Features

-   **Laravel Framework**: Built on the latest stable version of Laravel 12 + blade
-   **Authentication**: Complete user authentication system
-   **Authorization**: Role-based access control (RBAC)
-   **Database**: Pre-configured database migrations and seeders
-   **API Support**: RESTful API endpoints with proper documentation
-   **Frontend**: Modern frontend setup with Tailwind CSS
-   **Testing**: Comprehensive test suite with Pest
-   **Code Quality**: ESLint, Prettier, and PHP CS Fixer configurations

## Requirements

-   PHP >= 8.1
-   Composer
-   Node.js >= 16.x
-   NPM or Yarn
-   MySQL/PostgreSQL/SQLite
-   Redis (optional)

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/zakialawi02/starter-pack-laravel12.git
    cd starterpack-laravel12
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies**

    ```bash
    npm install
    ```

4. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Database setup**

    ```bash
    php artisan migrate --seed
    ```

6. **Build frontend assets**
    ```bash
    npm run build
    ```

## Configuration

### Environment Variables

Update your `.env` file with the following configurations:

```env
APP_NAME="StarterPack Laravel"
APP_ENV=local
APP_KEY=base64:your-app-key
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=starterpack_laravel
DB_USERNAME=root
DB_PASSWORD=
```

### Database Configuration

1. Create a new database for your project
2. Update the database credentials in your `.env` file
3. Run migrations and seeders:
    ```bash
    php artisan migrate:fresh --seed
    ```

## Usage

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

Start the Vite development server for frontend assets:

```bash
npm run dev
```

### Default Credentials

After running the seeders, you can login with:

-   **Email**: superadmin@mail.com
-   **Password**: superadmin
    OR
-   **Email**: admin@mail.com
-   **Password**: admin
    OR
-   **Email**: user@mail.com
-   **Password**: user

## Project Structure

```
starterpack-laravel12/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├─ Api/
│   │   │   │  └─ Auth/
│   │   │   └─ Auth/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── Services/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── docs/
├── public/
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   ├── components/
│   │   ├── layouts/
│   │   └── pages/
│   ├── js/
│   └── css/
├── routes/
│   ├── api
│   │   └── auth.php
│   ├── api.php
│   ├── auth.php
│   └── web.php
├── storage/
├── tests/
│   ├── Feature/
│   └── Unit/
└── vendor/
```

## Development

### Code Style

This project follows PSR-12 coding standards. Run the following commands to maintain code quality:

```bash
# PHP CS Fixer
./vendor/bin/php-cs-fixer fix

# PHPStan (Static Analysis)
./vendor/bin/phpstan analyse

# ESLint (JavaScript)
npm run lint

# Prettier (Code Formatting)
npm run format
```

## Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run tests with coverage
php artisan test --coverage
```

### Writing Tests

-   Place feature tests in `tests/Feature/`
-   Place unit tests in `tests/Unit/`
-   Follow the naming convention: `{ClassName}Test.php`

## Deployment

### Production Setup

1. **Environment Configuration**

    ```bash
    APP_ENV=production
    APP_DEBUG=false
    ```

2. **Optimize for Production**

    ```bash
    composer install --optimize-autoloader --no-dev
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    npm run build
    ```

3. **Database Migration**
    ```bash
    php artisan migrate --force
    ```

## API Documentation

API documentation is available at `docs/` or [API DOCS](https://documenter.getpostman.com/view/25223819/2sAYkLoHLh)

### Authentication

The API uses Laravel Sanctum for authentication. Include the bearer token in your requests:

```bash
Authorization: Bearer {your-token}
```

### Example Endpoints

-   `POST /api/auth/login` - Login
-   `POST /api/auth/register` - Register
-   `GET /api/users` - Get all users
-   `POST /api/users` - Create a new user
-   `GET /api/users/{id}` - Get user by ID
-   `PUT /api/users/{id}` - Update user
-   `DELETE /api/users/{id}` - Delete user

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

-   Follow PSR-12 coding standards
-   Write comprehensive tests for new features
-   Update documentation as needed
-   Ensure all tests pass before submitting PR

## Security

If you discover any security vulnerabilities, please send an email to hallo@zakialawi.my.id instead of using the issue tracker.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support and Donations

If you find this project useful and would like to support its further development, you can make a donation via the following platforms:

https://ko-fi.com/zakialawi

Every contribution you make is greatly appreciated. Thank you!

-   **Documentation**: [Wiki](https://github.com/zakialawi02/starterpack-laravel12/wiki)
-   **Issues**: [GitHub Issues](https://github.com/zakialawi02/starterpack-laravel12/issues)
-   **Discussions**: [GitHub Discussions](https://github.com/zakialawi02/starterpack-laravel12/discussions)

## Acknowledgments

-   [Laravel Framework](https://laravel.com/)
-   [Tailwind CSS](https://tailwindcss.com/)
-   [Vite](https://vitejs.dev/)
-   All contributors who have helped make this project better

---

**Happy Coding! 🚀**

---

_Note: This README is a general template. Please ensure to update it with specific details about your project, including features, installation instructions, usage guidelines, and contribution policies._
