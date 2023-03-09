# Rss-reader-app
Laravel RSS Reader application

## Instalation

To run the project you have to install **docker**.

You can read about installation here https://docs.docker.com/install/, just choose your OS.

For UNIX users - nothing else.

For WINDOWS users - you have to install MAKE by your own.

## How to see it

`http://localhost:8080/` - to see the app in browser.
1) Posts `http://localhost:8080/posts` - to see the post.
2) Button `Get new post` - to get new post from RSS feed. Job will be added to queue. Then you have to refresh page to see new post.

## How to use it

Run `make start` to start server. All containers will start automatically.

## How to start it first time
If you start it first time, you have to :
1) Create `.env` file from `.env.example` in src folder.
2) Run `make start` to start server in root folder.
3) Run `make composer_install` to install composer dependencies.
4) Run `make migration_db` to migrate database.
5) Run `make start_queue` to start background queue.
6) `http://localhost:8080/` - to see the app in browser.

## Composer install

Run `make composer_install` to install composer dependencies.

## Migration database

Run `make migration_db` to migrate database.

## Start queue after start

Run `make start_queue` to start background queue.

## How to stop it

Run `make stop` to stop server. All containers will stop automatically.
