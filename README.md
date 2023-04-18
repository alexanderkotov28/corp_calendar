# corp_calendar

### Deployment
- Create `.env` file by `.env.example`
- Set `DOCKER_MYSQL_ROOT_PASSWORD`
- Set `DOCKER_MYSQL_DB`
- Set `DOCKER_MYSQL_USER`
- Set `DOCKER_MYSQL_PASSWORD`
- Set `DOCKER_NGINX_PORT`
- Run `docker network create corp_calendar`
- For using local NPM create `.env` file in `client` directory. Then set `APP_URL` which is the `corp_calendar.nginx` container address
- Run `docker-compose up -d`
- Run `docker exec -i corp_calendar.fpm composer install`
- Run `docker exec -i corp_calendar.fpm php artisan key:generate`
- Run `docker exec -i corp_calendar.fpm php artisan migrate`
- Run `docker exec -i corp_calendar.fpm php artisan db:seed`
