SHELL ?= /bin/bash

ARGS = $(filter-out $@,$(MAKECMDGOALS))

composer-require:
	docker-compose run composer composer require ${ARGS}

docker-build:
	docker-compose down
	docker-compose build
	docker-compose up -d

docker-build-no-cache:
	docker-compose down
	docker-compose build --no-cache
	docker-compose up -d

docker-restart:
	docker-compose down
	docker-compose up -d

composer-install:
	docker-compose run composer composer install

migrate-fresh:
	docker-compose exec php php artisan migrate:fresh --seed

migrate:
	docker-compose exec php php artisan migrate

migrate-seed:
	docker-compose exec php php artisan migrate --seed

key-gen:
	docker-compose exec php php artisan key:generate

bash:
	docker-compose exec php bash

cache-clear:
	docker-compose exec php php artisan cache:clear && php artisan view:clear && php artisan route:clear && php artisan config:clear
	#docker-compose exec php php artisan view:clear
	#docker-compose exec php php artisan route:clear
	#docker-compose exec php php artisan config:clear

fix-permissions:
	docker-compose exec php chown -R 1000:1001 .

test:
	docker-compose exec php php artisan test

route-list:
	docker-compose exec php php artisan route:list
