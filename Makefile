.SILENT:
.DEFAULT_GOAL:=help

DOCKER_COMPOSE = docker compose

up: ## Start the containers
	@$(DOCKER_COMPOSE) up -d

down: ## Stop the containers
	@$(DOCKER_COMPOSE) down

build: ## Build the Docker image
	@$(DOCKER_COMPOSE) build

exec: ## Execute commands in the php container (usage: make exec COMMAND="bin/console app:day01")
	@$(DOCKER_COMPOSE) exec php ${COMMAND}

bash: ## Access the shell of the php container
	@$(DOCKER_COMPOSE) exec php bash

composer-install: ## Install composer dependencies
	@$(DOCKER_COMPOSE) exec php composer install

console: ## Run Symfony console command (usage: make console CMD="cache:clear")
	@$(DOCKER_COMPOSE) exec php php bin/console ${CMD}

test: ## Run PHPUnit tests
	@$(DOCKER_COMPOSE) exec php php bin/phpunit

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
