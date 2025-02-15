
# News-Aggregator challenge app

## Description

Versions:

Php: 8.1
Laravel: 10.10

## Install

        $ composer install
        $ composer create-project laravel/laravel news-aggregator-app

Add and update the docker file for running docker environment:

        $ docker-compose -f docker-compose.yaml up -d
        $ composer require laravel/sanctum
        $ ./dock php php artisan migrate

To fetch Articles create command file:

     $ php artisan make:command FetchNewsCommand

## API Documentation

    For the APIs, goto url https://editor.swagger.io/  and paste the json from the file news-aggregator-api-collection.json and will get the APIs in SwaggerUI.
    Also, the postman collection is added in the file postman-collection.json 