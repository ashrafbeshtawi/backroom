# Backroom
A zero configuration App built with Symfony, Docker, Postgresql, Flyway & Nuxt.js
### initial Setup (only once)
```bash
chmod +x bin/phpunit
chmod +x bin/build
chmod +x bin/symfony
```
### Boot-Up the project
```bash
bin/build
```

### Create Symfony Database Migration (check if you really have to)
```bash
bin/symfony create
```

## Run Php-Unit
```bash
bin/phpunit PATH_TO_UNIT
```

## Run Database Migration (optional)
```bash
dc up flyway
```


