# Condo Management

This application

## Requirements
- Linux
- Docker

## Installation
1. Copy .env file
```
cp .env.exxample .env
```
2. Install composer dependecies
```
docker run --rm --interactive --tty -v $(pwd):/app composer install
``` 
3. Run sail
```
./vendor/bin/sail up -d
```
4. Generate App key
```
./vendor/bin/sail artisan key:generate
```
5. Run tests
```
./vendor/bin/sail test
```
6. Run migrations and seeders
```
./vendor/bin/sail artisan migrate --seed
```
