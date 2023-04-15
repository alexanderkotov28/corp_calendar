# corp_calendar_api

### Deployment
- Create `.env` file by `.env.example`
- Set `DOCKER_MYSQL_ROOT_PASSWORD`
- Set `DOCKER_MYSQL_DB`
- Set `DOCKER_MYSQL_USER`
- Set `DOCKER_MYSQL_PASSWORD`
- Set `DOCKER_NGINX_PORT`
- Run `docker network create corp_calendar`
- Run `docker-compose up -d`
- Run `docker-compose run --rm corp_calendar.fpm composer install`
- Run `docker-compose run --rm corp_calendar.fpm php artisan key:generate`
- Run `docker-compose run --rm corp_calendar.fpm php artisan migrate`
- Run `docker-compose run --rm corp_calendar.fpm php artisan app:init-admin`
