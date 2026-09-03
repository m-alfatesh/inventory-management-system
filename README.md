# Mini Inventory Management System

## Description

A backend REST API for managing product categories, products, stock movements, and inventory reports.

The project was developed as the final project of the practical training program using Laravel, MySQL, Docker, GitHub Actions, and a cloud virtual machine.

## Features

- Category CRUD
- Product CRUD
- Product-category relationships
- Stock In and Stock Out operations
- Stock movement history
- Stock validation
- Prevention of negative stock
- Low Stock report
- Out of Stock report
- Inventory Summary
- Form Request validation
- Automated tests
- Docker and Docker Compose
- GitHub Actions CI
- Cloud deployment
- Docker logs and basic monitoring

## Technologies

- Ubuntu / Linux
- Laravel 13
- PHP 8.4
- MySQL 8.0
- REST API
- Eloquent ORM
- Laravel Migrations
- Form Requests
- PHPUnit
- Docker
- Docker Compose
- Git / GitHub
- GitHub Actions
- DigitalOcean
- Postman

## Database Structure

The system contains three main tables:

### Categories

- `id`
- `name`
- `description`
- `created_at`
- `updated_at`

### Products

- `id`
- `category_id`
- `name`
- `description`
- `price`
- `quantity`
- `minimum_stock`
- `is_active`
- `created_at`
- `updated_at`

### Stock Movements

- `id`
- `product_id`
- `type`
- `quantity`
- `note`
- `created_at`
- `updated_at`

### Relationships

- A category has many products.
- A product belongs to one category.
- A product has many stock movements.
- A stock movement belongs to one product.


## Installation

Clone the repository:

git clone git@github.com:m-alfatesh/inventory-management-system.git
cd inventory-management-system

Install dependencies:

composer install

Create the environment file:

cp .env.example .env

Generate the application key:

php artisan key:generate

Configure the database in `.env`, then run:

php artisan migrate

Start the application:

php artisan serve

The API will be available at:

http://127.0.0.1:8000

## Environment

Database configuration is stored in the `.env` file.

Example:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=inventory
DB_PASSWORD=your_password

The `.env` file is not committed to GitHub.

## API Endpoints

### Categories

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/categories` | List categories |
| GET | `/api/categories/{id}` | Get category |
| POST | `/api/categories` | Create category |
| PUT | `/api/categories/{id}` | Update category |
| DELETE | `/api/categories/{id}` | Delete category |

### Products

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/products` | List products |
| GET | `/api/products/{id}` | Get product |
| POST | `/api/products` | Create product |
| PUT | `/api/products/{id}` | Update product |
| DELETE | `/api/products/{id}` | Delete product |

### Stock

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/products/{id}/stock-in` | Add stock |
| POST | `/api/products/{id}/stock-out` | Remove stock |
| GET | `/api/products/{id}/movements` | View movement history |

### Reports

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/reports/low-stock` | Low Stock products |
| GET | `/api/reports/out-of-stock` | Out of Stock products |
| GET | `/api/reports/summary` | Inventory summary |

## Business Rules

- Product price cannot be negative.
- Stock movement quantity must be greater than zero.
- Stock In increases product quantity.
- Stock Out decreases product quantity.
- Stock quantity can never become negative.
- Stock Out exceeding available stock is rejected.
- Every Stock In and Stock Out operation is recorded.
- Low Stock is based on `minimum_stock`.
- Out of Stock means quantity equals zero.

## Validation

Form Requests are used for API validation.

The application validates:

- Required fields
- Data types
- Existing category IDs
- Non-negative prices
- Non-negative product quantities
- Positive stock movement quantities
- Boolean values

## Automated Tests

The project includes automated tests for:

1. Product creation.
2. Invalid product validation.
3. Stock In.
4. Stock Out.
5. Insufficient stock rejection.
6. Low Stock reporting.

Run the tests:

php artisan test

## Docker

Build the Docker image:

docker build -t inventory-management-system .

Run the application using Docker Compose:

docker compose up -d

Check the containers:

docker compose ps

Run migrations:

docker compose exec app php artisan migrate

Stop the services:

docker compose down

MySQL data is stored using a Docker volume to provide data persistence after container restart.

## GitHub Actions

GitHub Actions is used for Continuous Integration.

The CI workflow:

1. Checks out the repository.
2. Sets up PHP.
3. Installs Composer dependencies.
4. Prepares the Laravel environment.
5. Runs automated tests.
6. Builds the Docker image when the tests pass.

If the tests fail, the Docker build is not executed.

## Git Workflow

The project uses:

- `main`
- `develop`
- Feature branches

Changes are integrated through Pull Requests.

Repository:

https://github.com/m-alfatesh/inventory-management-system

## Cloud Deployment

The application was deployed to an Ubuntu cloud virtual machine.

The deployment process includes:

1. Connecting through SSH using a non-root user.
2. Pulling the project from GitHub.
3. Configuring the server `.env`.
4. Starting Laravel and MySQL with Docker Compose.
5. Running database migrations.
6. Verifying the containers.
7. Testing the API through the public IP.

Example:

http://PUBLIC_IP:8000/api/products

The server `.env` file is kept outside the Git repository.

## Logs and Monitoring

View application and database logs:

docker compose logs

View application logs:

docker compose logs app

View MySQL logs:

docker compose logs mysql

Check container resources:

docker stats

Check container status:

docker compose ps

## Project Structure

app/
├── Http/
│   ├── Controllers/
│   └── Requests/
└── Models/

database/
└── migrations/

routes/
└── api.php

tests/
└── Feature/

Dockerfile
docker-compose.yml
README.md

## Screenshots

The project includes screenshots documenting:

- Database tables
- Automated tests
- GitHub Actions
- Docker images
- Docker containers
- Docker statistics
- Docker logs
- Category creation
- Product creation
- Stock In
- Stock Out
- Insufficient stock rejection
- Movement history
- Low Stock report
- Inventory Summary
- Public API
- Public IP and port

## Acknowledgment

I would like to express my sincere gratitude to my training supervisor, **Eng. Moatasem Alhilali**, and **Dr. Riyadh Al-Ghaili** for their guidance, support, and valuable feedback throughout my training period.

I would also like to extend my appreciation to **Abaad Al-Atmata Company (Abaadcom)** for providing me with this valuable training opportunity and for creating a supportive environment that allowed me to develop my technical skills and gain practical experience in software engineering.

## Repository

GitHub:

https://github.com/m-alfatesh/inventory-management-system
