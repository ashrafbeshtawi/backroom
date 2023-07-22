# Backroom
A zero configuration App built with Symfony, Docker, Postgresql, Flyway & Nuxt.js

### Boot-Up the project
```bash
chmod +x bin/build
bin/build
```

### Create Symfony Database Migration (check if you really have to)
```bash
docker exec symfony bin/console doctrine:migrations:diff
```

## Run Php-Unit
```bash
docker exec symfony bin/phpunit PATH_TO_UNIT
```

## Run Database Migration (optional)
```bash
dc up flyway
```


