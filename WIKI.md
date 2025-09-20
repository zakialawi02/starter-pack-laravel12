# Starter Pack Laravel 12

A comprehensive Laravel 12 starter pack with pre-configured components and features to accelerate your web application development.

## Table of Contents

-   [Project Overview](#project-overview)
-   [Features](#features)
-   [Project Structure](#project-structure)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Key Components](#key-components)
-   [Available Actions](#available-actions)
-   [Helpers](#helpers)
-   [Views and Layouts](#views-and-layouts)
-   [Routing](#routing)
-   [Testing](#testing)
-   [Development Guidelines](#development-guidelines)

## Project Overview

This starter pack provides a solid foundation for building web applications with Laravel 12. It includes commonly needed components, configurations, and best practices to help you get started quickly.

## Features

-   Laravel 12 framework
-   Pre-configured authentication system
-   Admin panel layouts
-   Front-end layouts
-   Action classes for business logic
-   Helper functions
-   DataTables integration
-   File upload handling
-   Disposable email validation
-   Sentry error tracking
-   Sanctum API authentication
-   Comprehensive testing setup

## Project Structure

```
starter-pack-laravel12/
├── app/
│   ├── Actions/              # Business logic action classes
│   ├── Helpers/              # Helper functions
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   ├── Middleware/       # Custom middleware
│   │   ├── Requests/         # Form request validation
│   │   └── Resources/        # API resources
│   ├── Models/               # Eloquent models
│   ├── Providers/            # Service providers
│   └── View/Components/      # Blade components
├── bootstrap/                # Application bootstrap files
├── config/                   # Configuration files
├── database/                 # Database migrations and seeds
├── public/                   # Publicly accessible files
├── resources/                # Views, styles, and scripts
├── routes/                   # Route definitions
├── storage/                  # File storage
├── tests/                    # Automated tests
├── vendor/                   # Composer dependencies
└── .env.example              # Environment configuration example
```

## Installation

1. Clone the repository:

    ```bash
    git clone <repository-url>
    ```

2. Install PHP dependencies:

    ```bash
    composer install
    ```

3. Install Node dependencies:

    ```bash
    npm install
    ```

4. Copy and configure the environment file:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. Configure your database in the `.env` file

6. Run database migrations:

    ```bash
    php artisan migrate
    ```

7. Run database seeders (if any):

    ```bash
    php artisan db:seed
    ```

8. Compile assets:

    ```bash
    npm run dev
    # or for production
    npm run build
    ```

9. Start the development server:
    ```bash
    php artisan serve
    ```

## Configuration

### Environment Variables

Key environment variables to configure in your `.env` file:

-   `APP_NAME` - Application name
-   `APP_ENV` - Environment (local, production, etc.)
-   `APP_KEY` - Application encryption key
-   `APP_DEBUG` - Debug mode
-   `APP_URL` - Application URL
-   `DB_*` - Database connection settings
-   `MAIL_*` - Mail configuration
-   `QUEUE_CONNECTION` - Queue driver
-   `SESSION_DRIVER` - Session driver
-   `SENTRY_LARAVEL_DSN` - Sentry error tracking

### Key Configuration Files

-   [config/app.php](./config/app.php) - Application configuration
-   [config/auth.php](./config/auth.php) - Authentication configuration
-   [config/database.php](./config/database.php) - Database configuration
-   [config/filesystems.php](./config/filesystems.php) - Filesystem configuration
-   [config/mail.php](./config/mail.php) - Mail configuration
-   [config/queue.php](./config/queue.php) - Queue configuration
-   [config/services.php](./config/services.php) - Third-party services

## Key Components

### Actions

Action classes encapsulate business logic:

-   [app/Actions/DeletePostPermanently.php](./app/Actions/DeletePostPermanently.php) - Permanently deletes a post
-   [app/Actions/UploadCoverImage.php](./app/Actions/UploadCoverImage.php) - Handles cover image uploads

### Helpers

Helper functions to simplify common tasks:

-   [app/Helpers/Breadcrumb.php](./app/Helpers/Breadcrumb.php) - Breadcrumb navigation helper

### View Components

Blade components for consistent UI:

-   [app/View/Components/AppFrontLayout.php](./app/View/Components/AppFrontLayout.php) - Front-end layout component
-   [app/View/Components/AppLayout.php](./app/View/Components/AppLayout.php) - Admin/application layout component
-   [app/View/Components/GuestLayout.php](./app/View/Components/GuestLayout.php) - Guest layout component

### Models

-   [app/Models/User.php](./app/Models/User.php) - User model with authentication

## Available Actions

### DeletePostPermanently

Permanently deletes a post from the database.

Usage:

```php
use App\Actions\DeletePostPermanently;

$action = new DeletePostPermanently();
$action->execute($postId);
```

### UploadCoverImage

Handles uploading and processing of cover images.

Usage:

```php
use App\Actions\UploadCoverImage;

$action = new UploadCoverImage();
$result = $action->execute($request);
```

## Helpers

### Breadcrumb

Generates breadcrumb navigation for pages.

Usage:

```php
use App\Helpers\Breadcrumb;

$breadcrumbs = Breadcrumb::generate([
    'Home' => '/',
    'Category' => '/category',
    'Current Page' => ''
]);
```

## Views and Layouts

The project includes several pre-built layouts:

1. **AppLayout** - Main application layout with navigation
2. **GuestLayout** - Layout for guest/unauthenticated pages
3. **AppFrontLayout** - Front-end website layout

To use a layout in your Blade views:

```blade
<x-app-layout>
    <div class="container">
        <!-- Your content here -->
    </div>
</x-app-layout>
```

## Routing

Routes are organized in the [routes/](./routes) directory:

-   [routes/web.php](./routes/web.php) - Web routes
-   [routes/api.php](./routes/api.php) - API routes
-   [routes/auth.php](./routes/auth.php) - Authentication routes
-   [routes/console.php](./routes/console.php) - Console commands

## Testing

The project includes a testing setup using PestPHP:

-   [tests/Feature/](./tests/Feature) - Feature tests
-   [tests/Unit/](./tests/Unit) - Unit tests

To run tests:

```bash
./vendor/bin/pest
```

## Development Guidelines

### Code Organization

1. Place business logic in Action classes in the [app/Actions/](./app/Actions) directory
2. Create helper functions in the [app/Helpers/](./app/Helpers) directory
3. Use View Components for reusable UI elements
4. Follow Laravel conventions for naming and structure

### Best Practices

1. Use form request validation for controller validation
2. Keep controllers thin and delegate to actions
3. Use Eloquent models for database interactions
4. Implement proper error handling
5. Write tests for critical functionality
6. Use environment variables for configuration
7. Follow PSR-12 coding standards

### Adding New Features

1. Create a new Action class for business logic
2. Add necessary routes in the appropriate routes file
3. Create controllers to handle HTTP requests
4. Build views using the existing layout components
5. Add feature tests to verify functionality
6. Update this wiki documentation

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
