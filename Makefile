#!/usr/bin/make
SHELL = /bin/sh
include .env

PROJECT_NAME = $(COMPOSE_PROJECT_NAME)
ifeq (,$(PROJECT_NAME)) ## check project name
ERR_PROJECT_NAME = $(error PROJECT_NAME is empty. please set PROJECT_NAME in .env first)
endif

DOCKER_COMPOSE = docker compose -p $(PROJECT_NAME)
DOCKER_EXEC = $(DOCKER_COMPOSE) exec

ifeq (,$(APP_KEY))
GENERATE_KEY = key-generate
endif

###############
# ERROR CHECK #
###############
.PHONY: error
error:
	$(ERR_PROJECT_NAME)

#############################
# DOCKER COMPOSE MANAGEMENT #
#############################
.PHONY: build
build: error ## Build docker stack
	$(DOCKER_COMPOSE) build

.PHONY: build-no-cache
build-no-cache: error ## Build docker stack without cache
	$(DOCKER_COMPOSE) build --no-cache

.PHONY: up
up: error ## Start docker stack
	$(DOCKER_COMPOSE) up -d --force-recreate --remove-orphans

.PHONY: down
down: error ## Stop and remove docker stack
	$(DOCKER_COMPOSE) down --remove-orphans

.PHONY: restart
restart: error ## Restart docker stack
	$(DOCKER_COMPOSE) restart

.PHONY: restart-%
restart-%: error ## Restart docker stack
	$(DOCKER_COMPOSE) restart $*

.PHONY: services-show
services-show: error ## Show docker container list
	$(DOCKER_COMPOSE) ps

.PHONY: config-test
config-test: error ## Test and show final stack config
	$(DOCKER_COMPOSE) config

.PHONY: logs
logs: error ## Check all container logs
	$(DOCKER_COMPOSE) logs -f

.PHONY: logs-%
logs-%: error ## Check container logs of service %
	$(DOCKER_COMPOSE) logs -f $*

.PHONY: connect-app
connect-app: error # connect to app container terminal
	$(DOCKER_EXEC) app sh



############################
# PROJECT SPESIFIC COMMAND #
############################
.PHONY: setup
setup: error
	$(DOCKER_COMPOSE) run --rm --entrypoint="" app $(MAKE) setup-in-docker
	$(DOCKER_COMPOSE) down

.PHONY: composer-install-dev
composer-install-dev: error
	$(DOCKER_EXEC) app composer install || true

.PHONY: composer-install
composer-install: error
	$(DOCKER_EXEC) app composer install --no-dev --no-interaction --ignore-platform-req

.PHONY: dump-autoload
dump-autoload: error
	$(DOCKER_EXEC) app composer dump-autoload

.PHONY: npm-install
npm-install: error
	$(DOCKER_EXEC) app npm install

.PHONY: optimize
optimize: error
	$(DOCKER_EXEC) app php artisan optimize:clear

.PHONY: migrate
migrate: error
	$(DOCKER_EXEC) app php artisan migrate --seed --force

.PHONY: migrate-refresh
migrate-refresh: error
	$(DOCKER_EXEC) app php artisan migrate:refresh --seed

.PHONY: key-generate
key-generate: error
	$(DOCKER_EXEC) app php artisan key:generate

.PHONY: build-vite
build-vite: error
	$(DOCKER_EXEC) app npm run build

.PHONY: monitor-schedule
monitor-schedule: error
	$(DOCKER_EXEC) app php artisan schedule-monitor:list



############################
# START DEVELOPMENT SERVER #
############################
.PHONY: start-dev
start-dev: # executing on host or inside container
	npx vite --host & \
	php -d variables_order=EGPCS artisan octane:start --server=swoole --host=0.0.0.0 --port=${OCTANE_PORT}  --watch

.PHONY: start-dev-docker
start-dev-docker: error # executing inside container from host
	$(DOCKER_EXEC) app $(MAKE) start-dev



#############
# UTILITIES #
#############
.PHONY: setup-in-docker
setup-in-docker:
	composer install --no-interaction
	php artisan key:generate || true
	php artisan migrate:fresh --seed
	npm install

.PHONY: list
list:
	@LC_ALL=C $(MAKE) -pRrq -f $(firstword $(MAKEFILE_LIST)) : 2>/dev/null | awk -v RS= -F: '/(^|\n)# Files(\n|$$)/,/(^|\n)# Finished Make data base/ {if ($$1 !~ "^[#.]") {print $$1}}' | sort | grep -E -v -e '^[^[:alnum:]]' -e '^$@$$'
