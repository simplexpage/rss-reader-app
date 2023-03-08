start:
	docker-compose up

composer_install:
	docker-compose run --rm php_apache_reader bash -c "composer install"

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