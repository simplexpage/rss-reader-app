start:
	docker-compose up

rebuild:
	docker-system prune
	docker-compose up --build

stop:
	docker-compose down

console_php:
	docker-compose exec php-apache /bin/bash