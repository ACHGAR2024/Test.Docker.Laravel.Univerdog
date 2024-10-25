CONTAINER_NAME=univerdog_laravel_app

docker-exec:
	docker exec -it $(CONTAINER_NAME) $(cmd)

migrate:
	$(MAKE) docker-exec cmd="php artisan migrate"

seed:
	$(MAKE) docker-exec cmd="php artisan db:seed"

migrate-seed:
	$(MAKE) docker-exec cmd="php artisan migrate --seed"

refresh:
	$(MAKE) docker-exec cmd="php artisan migrate:refresh --seed"

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

restart:
	$(MAKE) down
	$(MAKE) up
