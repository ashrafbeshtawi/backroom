# Backroom
A zero configuration App built with Symfony, Docker, Postgresql, Flyway & Nuxt.js

## Bootup the project
### init .env
```bash
cp .env-example .env
cp symfony/.env-example symfony/.env
```
### Create Symfony Database Mirgation
```bash
php bin/console doctrine:migrations:diff
```
### Run Symfony Database Mirgation
```bash
php bin/console doctrine:migrations:migrate
```
### Run the Project
```bash
 dc up
```

## Run Database Mirgation
```bash
dc up flyway
```


