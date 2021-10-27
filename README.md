### Installing
Starting the docker containers:
```sh
$ docker-compose up -d
```
Connecting to the docker container:
```sh
$ docker-compose exec php sh
```
Installing backend dependencies after connecting to the container for the first time
```sh
$ composer install
```
Creating database schema
```sh
$ php bin/console doctrine:schema:create
```
Loading data fixtures
```sh
$ php bin/console doctrine:fixtures:load -n
```
