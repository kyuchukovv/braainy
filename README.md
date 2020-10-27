## About Braainy Integrator

This is a simple web application integrating with an accounting software called [Billy](https://www.billy.dk/api/).
The project is created with the following tech stack: PHP, Laravel 8, Nginx, NPM, Docker, MDB(Material bootstrap)

## Prerequisites
- git
- docker && docker-compose

## Installation
```
  git clone git@github.com:kyuchukovv/braainy.git
  cd braainy
```
We will be using Docker to start every dependency for the project:
```shell script
  ["PHP", "NGINX", "NPM", "MYSQL", ];
```
Now just run:
```shell script
  docker-compose up -d
```
If you encounter error such as: "[ERROR] --initialize specified but the data directory has files in it. Aborting."
There is huge chance you are rinning out of space in your docker instance.
You can clean all unusued containers and volumes which are not attached to any containers:
```shell script
  docker system prune
  or better:
 docker system prune --volumes
```
Run 
```shell script
  docker-compose ps
```
To make sure all containers are live. Only 'braainy-npm' will be exited.

Next we move to installing packages via Composer.
```shell script
  docker-compose run --rm webapp composer install
```

Now Laravel part:
```shell script
  docker-compose run --rm webapp php artisan key:generate
```
Run migrations
```shell script
  docker-compose run --rm webapp php artisan migrate
```

In case of permission errors: 
```shell script
  docker-compose run --rm webapp chown -R www-data:www-data /www
  docker-compose run --rm webapp chmod -R 755 /www/storage
```
Lastly build install packages for the frontend:
```shell script
  docker-compose run --rm frontend install
```
## Running the app for the first time

Build the frontend with NPM and Laravel Miix to bundle resources(css, js)
```shell script
  docker-compose run --rm frontend run dev
```
Head to http://localhost to view the web application.
