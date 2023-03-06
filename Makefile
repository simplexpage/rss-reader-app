start:
	docker-compose up

migration_db:
	docker-compose run --rm php_apache_reader bash -c "php artisan migrate"

start_queue:
	docker-compose run --rm php_apache_reader bash -c "php artisan queue:work"

rebuild:
	docker system prune
	docker-compose up --build

stop:
	docker-compose down

console_php:
	docker-compose exec php_apache_reader /bin/bash