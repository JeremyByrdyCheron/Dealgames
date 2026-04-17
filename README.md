# Symfony Docker Project Setup

This repository contains a Docker-based development environment for a Symfony application ready to use.

## Prerequisites

- Docker
- Docker Compose
- Git

## Installation

1. Clone this repository:

```bash
git clone <repository-url>
cd <repository-name>
```

2. Start the Docker environment:

```bash
docker compose up -d --build
```

3. Install dependencies:

```bash
docker compose exec php composer install
```

4. Configure the `.env` file with the database credentials:

```dotenv
DATABASE_URL="mysql://symfony:symfony@database:3306/symfony?serverVersion=mariadb-10.11.2"
```

5. Create the database and run migrations:

```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

6. Fix permissions:

```bash
docker compose exec php chown -R www-data:www-data var
```

## Accessing the Application

- Application: http://localhost:8080
- phpMyAdmin: http://localhost:8081
- MailHog: http://localhost:8025

### Create an admin

- If not yet, create an account on [Register Page](http://localhost:8080/register)
- Then edit role on [Database](http://localhost:8081/index.php?route=/sql&pos=0&db=symfony&table=user) setting `["ROLE_ADMIN"]` and set `is_verified` to `1`

## Database Credentials

- Database: symfony
- Username: symfony
- Password: symfony

## Common Commands

Start the environment:

```bash
docker compose up -d
```

Stop the environment:

```bash
docker compose down
```

Clear the cache:

```bash
docker compose exec php php bin/console cache:clear
```

Access the PHP container:

```bash
docker compose exec php bash
```

## Troubleshooting

Permission issues:

```bash
docker compose exec php chown -R www-data:www-data var
```

Composer runs out of memory:

```bash
docker compose exec php php -d memory_limit=-1 /usr/bin/composer install
```

View logs:

```bash
docker compose logs -f
```
