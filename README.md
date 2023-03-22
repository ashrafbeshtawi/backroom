# Backroom
A zero configuration E-commerce built with Symfony, Docker, Postgresql, Flyway & Nuxt.js

## Bootup the project
```bash
 dc up
```

## Run Database Mirgation
```bash
dc up flyway
```

## Create Symfony Database Mirgation
```bash
php bin/console doctrine:migrations:diff
```

## Run Symfony Database Mirgation
```bash
php bin/console doctrine:migrations:migrate
```
