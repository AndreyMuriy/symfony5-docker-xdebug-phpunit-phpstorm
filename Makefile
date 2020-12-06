include .env
CURRENT_USER=$(shell id -u):$(shell id -g)

build:
	docker-compose -f .docker/docker-compose.yml build

up:
	docker-compose -f .docker/docker-compose.yml up -d

down:
	docker-compose -f .docker/docker-compose.yml down

install:
	docker-compose -f .docker/docker-compose.yml exec php-fpm symfony composer install

migrate:
	docker-compose -f .docker/docker-compose.yml exec php-fpm symfony console --no-interaction doctrine:migration:migrate

rm-db:
	sudo rm -rf .docker/storage/postgres

bash-php:
	docker-compose -f .docker/docker-compose.yml exec --user $(CURRENT_USER) php-fpm bash

root-bash-php:
	docker-compose -f .docker/docker-compose.yml exec php-fpm bash

start: build up install migrate
	@echo "Application has been launched"

test:
	docker-compose -f .docker/docker-compose.yml exec php-fpm bin/phpunit
