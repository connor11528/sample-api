# Capybara API

This is a sample API designed to record capybara observations. More notes about setting this project up are [available here](https://epiclaravel.dev/build-and-test-a-laravel-8-api/).

## Getting started

This codebase is set up with Laravel 8 and Laravel Sail for local development using Docker. Follow these steps to get started :)

- Clone repo and start Docker Desktop
- Run `vendor/bin/sail up` to start the Docker containers for PHP server, MySQL and Redis
- Run database seeder to add the acceptable locations to the locations table: `sail php artisan db:seed`

## Run tests

```
sail test
```

## Available endpoints

Right now this API has two endpoints for storing Capybaras and for storing Observations of Capybaras.

```
POST /api/capybaras - accepts name, color and size parameters
POST /api/observations - accepts capybara_name, sighting_date, location_name and wearing_hat parameters
```

## Areas for improvement
- We could add users table and authentication using Laravel Sanctum
- Add support for listing all observations of a Capybara
- Add support for all observations within a given location
- Add geolocation filtering to match observation to closest city location
