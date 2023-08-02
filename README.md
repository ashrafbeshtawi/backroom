# Backroom
A zero configuration App built with Symfony, Docker, Postgresql, Flyway & Nuxt.js
### initial Setup (only once)
```bash
chmod +x bin/phpunit
chmod +x bin/build
chmod +x bin/symfony
chmod +x bin/make

```
### Boot-Up the project
```bash
bin/build
```
## Useful Commands

### Create Symfony Database Migration
```bash
bin/symfony create
```
### Executes Symfony Database Migrations
```bash
bin/symfony migrate
```
### Create Symfony Class using console
```bash
bin/make somthing (like voter in symfony)
```
## Run Php-Unit
```bash
bin/phpunit PATH_TO_UNIT
```

## Run Database Migration (optional)
```bash
dc up flyway
```


