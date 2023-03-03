start_local:
	docker-compose up

start_local_rebuild:
	docker-system prune
	docker-compose up --build

stop_local:
	docker-compose down

console_php_local:
	docker-compose exec php-apache /bin/bash