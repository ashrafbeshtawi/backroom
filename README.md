# Backroom
A zero configuration App built with Symfony, Docker, Postgresql, Flyway & Nuxt.js

## Bootup the project
### init .env
```bash
cp .env-example .env
cp symfony/.env-example symfony/.env
```

### Run the Docker Containers
```bash
 dc up -d
```
### Generate the SSL keys
```bash
docker exec symfony bin/console lexik:jwt:generate-keypair
```
### Create Symfony Database Mirgation
```bash
docker exec symfony bin/console doctrine:migrations:diff
```
### Run Symfony Database Mirgation
```bash
docker exec symfony bin/console doctrine:migrations:migrate
```


## Run Database Mirgation
```bash
dc up flyway
```


