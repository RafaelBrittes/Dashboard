# Dashboard API

# Fixes to do:

- [ ] Create unit tests.
- [ ] Fix Cors error on file upload.
- [ ] Improve response time.

# Instalation
*Be sure to have Docker installed*.

Clone the repository.

Go to the project folder.

```sh
cd Product-Management/
```

Make the .env file
```sh
cp .env.example .env
```

Update the .env variables.
```dosini
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Run the Docker containers
```sh
docker-compose up -d
```

Access o container
```sh
docker-compose exec app bash
```

Install the dependencies
```sh
composer install
```

Generate the Laravel project key
```sh
php artisan key:generate
```

Run the migrations
```sh
php artisan migrate
```

Adminer open in http://localhost:8080/
Server: mysql
User: root
Password: root
Database: laravel
