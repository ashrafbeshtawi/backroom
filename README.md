# Backroom
A zero configuration App built with Symfony, Docker, Postgresql, Flyway & Nuxt.js
### initial Setup (only once)
```bash
chmod +x bin/phpunit
chmod +x bin/build
chmod +x bin/symfony
chmod +x bin/reset

```
### Boot-Up the project
```bash
bin/build
```
## Useful Commands

### Rebuild images
```bash
docker-compose up --build
```

### Rests Database & create & run migrations (you will lose all data)
```bash
bin/reset
```

### Create Symfony Database Migration
```bash
bin/symfony create
```
### Executes Symfony Database Migrations
```bash
bin/symfony migrate
```

## Run Php-Unit
```bash
bin/phpunit PATH_TO_UNIT
```


## Run Database Migration (optional)
```bash
dc up flyway
```

# API-Platform tricks (only in Symfony Container executable)
## Create Entity-Factory
```bash
bin/console make:factory
```

## Run Fixtures
```bash
bin/console doctrine:fixtures:load
```


