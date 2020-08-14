# Csv Reader
Csv Reader is simple csv manipulator built on laravel 7 & Vue 2.

# Installation
Csv Reader requires docker to run.

To install the project and run follow the commands.

```sh
$ docker-compose up -d --build site
$ docker-compose run --rm composer update
$ docker-compose run --rm artisan migrate
$ docker-compose run --rm npm install
$ docker-compose run --rm npm run dev
```

The project will be available at

```sh
http://localhost:8080
```
# Testing

You can run following command simply for testing.

```sh
$ docker-compose run --rm artisan test
```
