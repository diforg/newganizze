# newganizze
Newganizze is a personal finance management system focused on simplicity and clarity. It allows tracking income, expenses, accounts, categories, and financial overviews. This project is intended for learning, experimentation, and applying good software architecture practices, with no affiliation to any commercial product.

## Setup

1. Start the stack with `docker compose -f docker/docker-compose.yaml up -d --build`.
2. Create the local environment file with `cp src/.env.example src/.env`.
3. Generate the Laravel key with `docker compose -f docker/docker-compose.yaml run --rm app php artisan key:generate`.
4. Run the migrations with `docker compose -f docker/docker-compose.yaml run --rm app php artisan migrate`.

## Services

- Application: `http://localhost:8088`
- Vite: `http://localhost:5173`
- phpMyAdmin: `http://localhost:8080`
