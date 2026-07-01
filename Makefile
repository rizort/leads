SHELL = /bin/sh

UID := $(shell id --user)
GID := $(shell id --group)

export UID
export GID

# SHORTCUTS

init: docker-down-clear backend-clear docker-pull docker-build docker-up backend-init
up: docker-up
down: docker-down
restart: down up
update-deps: backend-deps-update restart

# DOCKER

docker-up:
	docker compose up --detach

docker-down:
	docker compose down --remove-orphans --timeout=1

docker-down-clear:
	docker compose down --volumes --remove-orphans --timeout=1

docker-pull:
	docker compose pull

docker-build:
	docker compose build --pull

# BACKEND

backend-clear:
	docker run --rm --volume "${PWD}/backend":/app --workdir /app alpine:3.23 sh -c 'rm -rf bootstrap/cache/* storage/framework/cache/* storage/logs/*'

backend-db-create:
	docker run --rm --volume "${PWD}/backend":/app --workdir /app alpine:3.23 sh -c 'touch database/database.sqlite'

backend-init: backend-env-create backend-db-create backend-permissions backend-deps-install backend-key-generate backend-migrations backend-fixtures
	
backend-permissions:
	docker run --rm --volume "${PWD}/backend":/app --workdir /app alpine:3.23 chmod 777 bootstrap/cache storage/framework/cache storage/logs

backend-deps-install:
	docker compose run --rm backend-php-cli composer install

backend-deps-update:
	docker compose run --rm backend-php-cli composer update

backend-key-generate:
	docker compose run --rm backend-php-cli php artisan key:generate --force

backend-migrations:
	docker compose run --rm backend-php-cli php artisan migrate --force

backend-fixtures:
	docker compose run --rm backend-php-cli php artisan db:seed --force

backend-php-cli:
	docker compose run --rm backend-php-cli $(filter-out $@,$(MAKECMDGOALS))

backend-env-create:
	cp backend/.env.example backend/.env
