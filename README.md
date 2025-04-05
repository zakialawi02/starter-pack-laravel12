# Laravel 12 Starter Pack

Welcome to the Laravel 12 Starter Pack! This repository provides a solid foundation for building robust and scalable web applications using Laravel 12.

## Features

- **Laravel 12**: Leverage the latest features and improvements of Laravel 12.
- **Pre-configured Environment**: Comes with a ready-to-use setup to streamline development.
- **Modular Structure**: Organized codebase following best practices for maintainability and scalability.
- **Authentication**: Built-in user authentication system. Using uuid for users table
- **Authorization**: Role-based access control for managing user permissions.
- **API Support**: Easily build and consume APIs with integrated support.
- **Testing Suite**: Pre-configured testing environment to ensure code reliability.

## Installation

Follow these steps to set up the project on your local machine:

1. **Clone the Repository**

    ```bash
    git clone https://github.com/zakialawi02/starter-pack-laravel12.git
    ```



2. **Navigate to the Project Directory**

    ```bash
    cd starter-pack-laravel12
    ```

3. **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

4. **Environment Configuration**

    - Copy the example environment file:

        ```bash
        cp .env.example .env
        ```

    - Generate the application key:

        ```bash
        php artisan key:generate
        ```

    - Configure your database and other environment settings in the `.env` file.

5. **Run Migrations**

    ```bash
    php artisan migrate
    ```

6. **Start the Development Server**

    ```bash
    php artisan serve
    ```

    Your application will be running at `http://localhost:8000`.

## Usage

This starter pack is designed to kickstart your Laravel 12 projects. Customize it according to your project requirements by adding new features, modifying existing ones, and integrating additional packages as needed.

## API DOCS

[API DOCS](https://documenter.getpostman.com/view/25223819/2sAYkLoHLh)

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please submit an issue or a pull request to the repository.

## License

This project is open-source and available under the [MIT License](LICENSE).

---

_Note: This README is a general template. Please ensure to update it with specific details about your project, including features, installation instructions, usage guidelines, and contribution policies._



