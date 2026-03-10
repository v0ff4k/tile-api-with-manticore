.PHONY: help build up start down restart logs ps shell migrate test

help:
	@echo "Available commands:"
	@echo "  make build      Build Docker images"
	@echo "  make up         Start containers in detached mode"
	@echo "  make install    Install composer lib in docker"
	@echo "  make start      Alias for up"
	@echo "  make down       Stop and remove containers"
	@echo "  make restart    Restart containers"
	@echo "  make logs       Follow logs"
	@echo "  make ps         Show running containers"
	@echo "  make shell      Open bash in PHP container"
	@echo "  make migrate    Run Doctrine migrations"
	@echo "  make test       Run tests"

build:
	docker-compose build --no-cache

up:
	docker-compose up -d

install:
	docker-compose exec php composer install

start: up

down:
	docker-compose down

restart: down up

logs:
	docker-compose logs -f

ps:
	docker-compose ps

shell:
	docker-compose exec php bash

migrate:
	docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction

test:
	docker-compose exec php bin/phpunit
