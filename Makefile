clear-cache:
	rm -rf var

phpstan:
	docker-compose run --rm -T php /usr/local/bin/php /app/vendor/bin/phpstan analyse --no-progress

phpunit: clear-cache
	docker-compose run --rm -T php /usr/local/bin/php /app/vendor/bin/phpunit

composer-update: clear-cache
	docker-compose run --rm -T php /usr/local/bin/php /usr/local/bin/composer update
