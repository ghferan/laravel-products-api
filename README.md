# Laravel Products API

A RESTful API built with Laravel 12 for managing products and categories, featuring token-based authentication, role-based authorization, request validation, image uploads, and automated feature tests.

## Features

- RESTful API for products and categories
- Token-based authentication with Laravel Sanctum
- Role-based authorization (`admin` and `user`)
- Form Request validation
- Product image uploads using Laravel public storage
- API Resources for consistent JSON responses
- Product search, filtering, sorting, and pagination
- Automated feature tests for authentication and authorization

## Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL 8
- Laravel Sanctum
- PHPUnit
- Composer

## Requirements

- PHP and the required Laravel extensions
- Composer
- MySQL
- Git

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/ghferan/laravel-products-api.git
   cd laravel-products-api
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Create the environment file:

   ```bash
   cp .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Create a MySQL database and configure the database credentials in `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_app
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

6. Run migrations:

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

### Products

| Method | Endpoint | Description | Access |
|---|---|---|---|
| GET | `/api/products` | List products | Public |
| GET | `/api/products/{product}` | Retrieve a product | Public, subject to controller authorization |
| POST | `/api/products` | Create a product | Admin |
| PUT/PATCH | `/api/products/{product}` | Update a product | Admin |
| DELETE | `/api/products/{product}` | Delete a product | Admin |

### Categories

| Method | Endpoint | Description | Access |
|---|---|---|---|
| GET | `/api/categories` | List categories | Public |
| GET | `/api/categories/{category}` | Retrieve a category | Public |
| POST | `/api/categories` | Create a category | Admin |
| PUT/PATCH | `/api/categories/{category}` | Update a category | Admin |
| DELETE | `/api/categories/{category}` | Delete a category | Admin |

### Authentication

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/register` | Register a user |
| POST | `/api/login` | Log in and obtain a token |
| POST | `/api/logout` | Log out |
| GET | `/api/user` | Retrieve the authenticated user |

Protected endpoints require a valid Sanctum bearer token. Administrative endpoints require an authenticated user with the `admin` role.

## Authentication

Include the token in the request headers:

```http
Authorization: Bearer YOUR_TOKEN
Accept: application/json
```

Obtain a token through the login endpoint and use it when calling protected endpoints.

## Image Upload

Send a `multipart/form-data` request with an `image` field containing the image file. Uploaded images are stored on Laravel's public disk.

Run `php artisan storage:link` to make public storage files accessible through the application's storage URL.

## Testing

Run the automated test suite:

```bash
php artisan test
```

The tests cover product operations, validation, image uploads, and authorization for guests, regular users, and administrators.

## Security

- Never commit `.env` or real credentials.
- Use `.env.example` as the configuration template.
- Use bearer tokens for protected endpoints.
- Keep production secrets out of source control.
- Restrict administrative operations to authorized administrators.

## License

This project is intended for learning and portfolio purposes. Add a license file if you plan to distribute it under a specific open-source license.
