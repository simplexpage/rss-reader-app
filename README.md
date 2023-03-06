# rss-reader-app
Laravel RSS Reader application

## Instalation

To run the project you have to install **docker**.

You can read about installation here https://docs.docker.com/install/, just choose your OS.

For UNIX users - nothing else.

For WINDOWS users - you have to install MAKE by your own.

## How to use it

Run `make start` to start server. All containers will start automatically.

## How to start it first time
If you start it first time, you have to create .env file from .env.example and run `make migration_db` to migrate database and `make start_queue` to start background queue.

## Migration database

Run `make migration_db` to migrate database.

## Start queue after start

Run `make start_queue` to start background queue.

## How to stop it

Run `make stop` to stop server. All containers will stop automatically.
