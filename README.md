# TIL_php
save what today I learned in Vanilla PHP(=No Framework)

# how to use

## how to launch
```bash
cd ./docker/
docker-compose up -d --build
docker-compose exec php bash
composer install
cp .env.example .env
```

## how to test
```bash
cd ./docker/
composer test
```