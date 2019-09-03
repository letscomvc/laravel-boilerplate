setup:
	@docker-compose build
	@docker-compose up -d
	@docker-compose run --rm app composer install
	@docker-compose run --rm app npm install
	@docker-compose run --rm app php artisan key:generate
	@docker-compose run --rm app php artisan migrate
	@docker-compose run --rm app php artisan upgrade --dev
	@docker-compose run --rm app npm run dev

restart:
	@docker-compose build
	@docker-compose up -d
clean:
	@docker-compose run --rm app rm -rf node_modules
	@docker-compose run --rm app npm cache clean --force
	@docker-compose down --remove-orphans
start:
	@docker-compose stop
	@docker-compose up -d
stop:
	@docker-compose stop
