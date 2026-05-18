install:
	composer install
dump:
	composer dump-autoload
lint:
	composer exec --verbose phpcs -- --standard=PSR12 routes
init:
	cp .env.example .env
	php artisan key:generate
	php artisan migrate
	php artisan db:seed
