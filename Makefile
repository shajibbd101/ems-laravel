.PHONY: help build up down logs ps mysql redis clean install key

help:
	@echo "EMS Docker Commands"
	@echo "==================="
	@echo "make install    - Install dependencies & setup"
	@echo "make build       - Build Docker images"
	@echo "make up          - Start all containers"
	@echo "make down        - Stop all containers"
	@echo "make logs        - View logs"
	@echo "make ps          - Show running containers"
	@echo "make key         - Generate app key"
	@echo "make migrate     - Run migrations"
	@echo "make seed        - Seed database"
	@echo "make clean       - Clean up containers & volumes"

install:
	@echo "Installing dependencies..."
	composer install --no-interaction
	npm install
	npm run build
	@echo "Setup complete!"

build:
	docker compose build --no-cache

up:
	docker compose up -d
	@echo "Waiting for services to be ready..."
	sleep 5
	@echo "Services started. Run 'make key' to generate app key"

down:
	docker compose down

logs:
	docker compose logs -f

ps:
	docker compose ps

key:
	docker compose exec -T app php artisan key:generate

migrate:
	docker compose exec -T app php artisan migrate --force

seed:
	docker compose exec -T app php artisan db:seed

clean:
	docker compose down -v --remove-orphans
	docker system prune -f