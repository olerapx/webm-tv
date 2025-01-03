include .env

APP_RUN = docker compose run -u www app

.PHONY: up
up:
	docker compose down
	docker compose build
	docker compose up -d --remove-orphans
	$(APP_RUN) composer install \
	    && $(APP_RUN) php8.3 artisan config:clear \
	    && $(APP_RUN) php8.3 artisan migrate --force \
	    && $(APP_RUN) npm install \
	    && $(APP_RUN) npm run build  \
	    && $(APP_RUN) php8.3 artisan view:cache \
	    && $(APP_RUN) php8.3 artisan route:cache \
	    && $(APP_RUN) php8.3 artisan config:cache

.PHONY: down
down:
	docker compose down

.PHONY: kill
kill:
	docker compose kill
