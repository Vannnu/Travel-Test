# Travel Booking System

This project is a travel and booking management system developed with Laravel 11 for the backend and Nuxt 3 for the frontend. It supports travel management, bookings, and automatic cart expiration handling.

## Requirements

- Docker & Docker Compose
- Composer
- Node.js & npm (for the frontend)

## Installation

### 1. Start Docker containers

```sh
docker compose up -d --build
```

### 2. Install backend dependencies

Access the PHP container:

```sh
docker exec -it laravel_app bash
```

Inside the container, run:

```sh
cp .env.example .env
php composer.phar install
php artisan key:generate
php artisan migrate:fresh
php artisan db:seed
```

## App

Go to app main page -> http://localhost:3000


## Running Tests

To run backend tests:

```sh
docker exec -it laravel_app bash -c "php artisan test"

This command will remove all the records in the DB. If you want 
to use the app you have to run again the command:

php artisan db:seed
```

## Linter & Fixer

To check PHP code:

```sh
docker exec -it laravel_app bash -c "php-cs-fixer fix --dry-run"
```

To automatically fix code:

```sh
docker exec -it laravel_app bash -c "php-cs-fixer fix"
```

## Useful Commands

Restart the system:

```sh
docker compose restart
```

Remove and recreate containers:

```sh
docker compose down -v && docker compose up -d --build
```

## Project Structure

- `checkout/` - Laravel 11 Backend
- `checkout-frontend/` - Nuxt 3 Frontend
- `nginx/` - Nginx Configuration
- `docker-compose.yml` - Service Configuration

## Implementation Decisions

- **Using Laravel 11** for travel and booking management due to its advanced Eloquent ORM features and job queue handling.
- **Nuxt 3 for the frontend**, leveraging SSR and a modular architecture.
- **Cart expiration management with a Laravel Job**, ensuring data consistency and minimizing concurrency issues when updating travel information.
- **MySQL 8 Database** for reliability and scalability.
- **Nginx as a reverse proxy**, optimizing request handling and performance.
- **Docker usage** to maintain a consistent development and production environment.

## Running the Queue Worker for Cart Expiration

To handle cart expiration jobs, you need to run the Laravel queue worker:

```sh
docker exec -it laravel_app bash -c "php artisan queue:work"
```

This ensures that expired carts are processed and travel seat availability is updated accordingly.

