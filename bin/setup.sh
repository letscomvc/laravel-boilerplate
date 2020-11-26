#!/bin/bash

docker-compose exec app cp .env.example .env
docker-compose exec app cp .env.testing.example .env.testing

docker-compose exec app composer install
docker-compose exec app php artisan migrate:fresh --seed
docker-compose exec app php artisan key:generate

docker-compose exec app npm install
docker-compose exec app npm run dev
