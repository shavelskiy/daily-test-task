#!/usr/bin/make

DOCKER_COMMAND = docker-compose run --rm -e XDEBUG_MODE=off php
DOCKER_COMMAND_WITH_DEBUG = docker-compose run --rm php
REGISTRY = registry.gitlab.com/akula-crm/crm-backend

init:
	start install reload-db tests

start:
	mkdir -p var
	touch .env.local
	docker-compose up --build -d

stop:
	docker-compose down

php:
	docker-compose exec php sh

db:
	docker-compose exec db psql -Upostgres

install:
	@$(DOCKER_COMMAND) composer install

migrate:
	@$(DOCKER_COMMAND) composer app doctrine:migrations:migrate -- --no-interaction

reload-db:
	@$(DOCKER_COMMAND) composer app doctrine:schema:drop -- --force --full-database --env=dev
	@$(DOCKER_COMMAND) composer app doctrine:migrations:migrate -- --no-interaction --env=dev
	@$(DOCKER_COMMAND) composer app doctrine:fixtures:load -- --no-interaction --env=dev

schema-validate:
	@$(DOCKER_COMMAND) composer app doctrine:schema:validate

check-autoload:
	@$(DOCKER_COMMAND) composer dump-autoload --strict-psr

php-fixer:
	@$(DOCKER_COMMAND) composer php-cs-fixer fix -- --allow-risky=yes

psalm:
	@$(DOCKER_COMMAND) composer psalm

symfony-lint:
	@$(DOCKER_COMMAND) composer app lint:container
	@$(DOCKER_COMMAND) composer app lint:yaml config

phpunit:
	@$(DOCKER_COMMAND_WITH_DEBUG) composer phpunit

phpunit-no-debug:
	@$(DOCKER_COMMAND) composer phpunit

tests: check-autoload php-fixer psalm symfony-lint phpunit-no-debug
