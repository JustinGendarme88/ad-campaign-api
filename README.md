# Ad Campaign API

A simple REST API built with Symfony for managing advertising campaigns.

## Features

- Create, read, update and delete ad campaigns (CRUD)
- Input validation with proper error handling
- JSON API responses
- Use of HTTP status codes (200, 201, 400, 404)
- SQLite database with Doctrine ORM

## Tech Stack

- PHP
- Symfony
- Doctrine ORM
- SQLite
- Git / GitHub

## API Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/ad-campaigns` | Get all campaigns |
| GET | `/api/ad-campaigns/{id}` | Get one campaign |
| POST | `/api/ad-campaigns` | Create a campaign |
| PUT | `/api/ad-campaigns/{id}` | Update a campaign |
| DELETE | `/api/ad-campaigns/{id}` | Delete a campaign |

## Example Request

```json
{
  "name": "Summer Campaign",
  "budget": 1000,
  "status": "active"
}
```

## How to run locally

### 1. Clone the repository
```bash
git clone https://github.com/JustinGendarme88/ad-campaign-api.git
```

### 2. Install dependencies
```bash
composer install
```

### 3. Run database migrations
```bash
php bin/console doctrine:migrations:migrate
```

### 4. Start the Symfony server
```bash
symfony server:start
```

### 5. Access the API
```text
http://127.0.0.1:8000/api/ad-campaigns
```

## About

This project demonstrates the implementation of a RESTful API using Symfony, including CRUD operations, input validation, and database interaction with Doctrine ORM.
