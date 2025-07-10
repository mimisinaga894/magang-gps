# Makefile untuk project Laravel Absensi

.PHONY: help build up down logs shell migrate seed fresh install

help: ## Tampilkan bantuan
	@echo "Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'

build: ## Build semua containers
	docker compose build --no-cache

up: ## Start semua services
	docker compose up -d

down: ## Stop semua services
	docker compose down

logs: ## Lihat logs semua services
	docker compose logs -f

shell: ## Masuk ke container PHP-FPM
	docker compose exec php-fpm /bin/sh

migrate: ## Jalankan migrasi database
	docker compose exec php-fpm php artisan migrate

seed: ## Jalankan database seeder
	docker compose exec php-fpm php artisan db:seed

fresh: ## Reset database dan jalankan seeder
	docker compose exec php-fpm php artisan migrate:fresh --seed

install: ## Install dependencies dan setup project
	docker compose exec php-fpm composer install --optimize-autoloader
	docker compose exec php-fpm php artisan key:generate
	docker compose exec php-fpm php artisan config:cache
	docker compose exec php-fpm php artisan route:cache
	docker compose exec php-fpm php artisan view:cache

restart: down up ## Restart semua services

clean: ## Bersihkan containers dan volumes
	docker compose down -v --remove-orphans
	docker system prune -f

deploy: build up install migrate ## Deploy lengkap (build, up, install, migrate)

status: ## Cek status containers
	docker compose ps
