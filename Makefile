install:
	composer install
dump:
	composer dump-autoload
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app routes database --ignore=app/Http/Controllers/Auth,storage,vendor
lint-r:
	composer exec --verbose phpcbf -- --standard=PSR12 app routes database
init:
	cp .env.example .env
	php artisan key:generate
	php artisan migrate:fresh --seed
start-dev:
	composer dev
test:
	php artisan test
test-c:
	php artisan test --coverage
test-h:
	php artisan test --coverage --coverage-html=coverage-report
