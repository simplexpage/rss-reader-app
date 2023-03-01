start_local:
	docker-compose up -d --build

stop_local:
	docker-compose down

console_php_local:
	docker-compose exec php-apache /bin/bash