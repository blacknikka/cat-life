
up:
	export WWWUSER=`id -g`; docker-compose up -d
bash:
	export WWWUSER=`id -g`; docker-compose exec --user www-data app bash
down:
	docker-compose down
build-app:
	docker image build -f infra/docker/8.1/php/Dockerfile -t catlife-app .
build-web:
	docker image build -f infra/docker/8.1/nginx/Dockerfile -t catlife-web .
generate-openapi:
	export WWWUSER=`id -g`; docker-compose exec --user `id -g` app /work/backend/vendor/bin/openapi /work/backend/app/Http --format yaml --output /work/backend/openapi/openapi.yaml
ide-helper:
	export WWWUSER=`id -g`; docker-compose exec --user `id -g` app php artisan ide-helper:model
phpstan:
	./vendor/bin/phpstan analyse --memory-limit=2G --configuration=phpstan.neon
