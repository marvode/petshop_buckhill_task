## About Petshop

Submission for Buckhill Backend Developer Test

## Requirements
- Php 8.2
- Composer 2
- Mysql 8.0

## Installation

Clone the repository

Then run the following commands from within the project directory

```bash
composer install
```

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

```bash
php artisan migrate --seed
```

You can run the unit tests with

```bash
php artisan test
```


## Usage

```bash
php artisan serve
```
Run this command to launch the application using the built-in PHP server.

The swagger documentation can be found at
[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)


