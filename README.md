# Laravel Products API

A RESTful API built with Laravel for managing products, with authentication, authorization, request validation, and automated feature tests.

## Features

- RESTful API endpoints for product management.
- Token-based authentication using Laravel Sanctum.
- Role-based authorization for administrative actions.
- Form Request validation for incoming data.
- Product image upload and public storage support.
- API Resources for consistent JSON responses.
- Automated feature tests for authentication and authorization.

## Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL 8
- Laravel Sanctum
- PHPUnit
- Composer

## Requirements

- PHP and the required Laravel PHP extensions
- Composer
- MySQL
- Git

## Installation

1. Clone the repository:

   ```bash
   git clone YOUR_REPOSITORY_URL
   cd my-api
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create your environment file:

   ```bash
   cp .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Configure your database credentials in `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_app
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

6. Run database migrations:

   ```bash
   php artisan migrate
   ```

7. Create the public storage link:

   ```bash
   php artisan storage:link
   ```

8. Start the development server:

   ```bash
   php artisan serve
   ```

The API will be available at `http://127.0.0.1:8000`.

## API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/products` | List products |
| POST | `/api/products` | Create a product |
| GET | `/api/products/{product}` | Retrieve a product |
| PUT/PATCH | `/api/products/{product}` | Update a product |
| DELETE | `/api/products/{product}` | Delete a product |
| GET | `/api/user` | Retrieve the authenticated user |

Protected endpoints require a valid Sanctum bearer token.

## Authentication

Send the token in the request header:

```http
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

## Image Upload

To upload a product image, send a `multipart/form-data` request with the image field set to a file.

Uploaded files are stored on the public disk. The `storage:link` command makes public files accessible through the application's storage URL.

## Testing

Run the automated test suite:

```bash
php artisan test
```

Current test result: **10 tests passed, 13 assertions**.

## Security

- Do not commit `.env` or real credentials.
- Use `.env.example` as the configuration template.
- Use a valid bearer token for protected endpoints.
- Keep production secrets out of source control.

## License

This project is available for learning and portfolio purposes. Add a license file if you intend to distribute it under a specific open-source license.
