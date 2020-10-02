current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: deps start

.PHONY: deps
deps: composer-install

# 🐘 Composer
composer-env-file:
	@if [ ! -f .env.local ]; then echo '' > .env.local; fi

.PHONY: composer-install
composer-install:
	@docker-compose exec php composer install

.PHONY: composer-update
composer-update: CMD=update

.PHONY: composer-require
composer-require: CMD=require
composer-require: INTERACTIVE=-ti --interactive

.PHONY: composer-require-module
composer-require-module: CMD=require $(module)
composer-require-module: INTERACTIVE=-ti --interactive

#.PHONY: composer
#composer composer-install composer-update composer-require composer-require-module: composer-env-file
#	@docker run --rm $(INTERACTIVE) --volume $(current-dir):/api --user $(id -u):$(id -g) \
#		composer:2 $(CMD) \
#			--ignore-platform-reqs \
#			--no-ansi

.PHONY: reload
reload: composer-env-file
	@docker-compose exec php kill -USR2 1

.PHONY: test
test: composer-env-file
	docker exec codelytv-php_ddd_skeleton-mooc_backend-php ./vendor/bin/phpunit --testsuite mooc
	docker exec codelytv-php_ddd_skeleton-mooc_backend-php ./vendor/bin/phpunit --testsuite shared
	docker exec codelytv-php_ddd_skeleton-mooc_backend-php ./vendor/bin/behat -p mooc_backend --format=progress -v
	docker exec codelytv-php_ddd_skeleton-backoffice_backend-php ./vendor/bin/phpunit --testsuite backoffice

.PHONY: run-tests
run-tests: composer-env-file
	mkdir -p build/test_results/phpunit
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite backoffice
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite mooc
	./vendor/bin/phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml --testsuite shared
	./vendor/bin/behat -p mooc_backend --format=progress -v

# 🐳 Docker Compose
.PHONY: start
start: CMD=up -d

.PHONY: stop
stop: CMD=stop

.PHONY: destroy
destroy: CMD=down

# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
.PHONY: doco
doco start stop destroy: composer-env-file
	@docker-compose $(CMD)

.PHONY: rebuild
rebuild: composer-env-file
	docker-compose build --pull --force-rm --no-cache
	make deps
	make start

.PHONY: ping-mysql
ping-mysql:
	@docker exec codelytv-php_ddd_skeleton-mooc-mysql mysqladmin --user=root --password= --host "127.0.0.1" ping --silent

clean-cache:
	@docker-compose exec php rm -Rf var/cache/

regenerate-types: dsd clean-entity generate-types dsc

.PHONY: generate-types
generate-types: clean-entity
	@docker-compose exec php vendor/bin/schema generate-types src/ config/schema.yaml

extract-cardinalities:
	@docker-compose exec php vendor/bin/schema extract-cardinalities

clean-entity: clean-cache
	@docker-compose exec php rm -rf src/Entity/
dsc:
	@docker-compose exec php bin/console doctrine:schema:create
dsu:
	@docker-compose exec php bin/console doctrine:schema:update --force
dsd:
	@docker-compose exec php bin/console doctrine:schema:drop --force
cpd:
	@docker-compose exec php bin/console cache:pool:delete
yarn:
	@docker-compose exec admin yarn add aor-rich-text-input

