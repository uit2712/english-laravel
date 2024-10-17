# Install
## Install docker
https://docs.docker.com/engine/install/
## Install composer
https://getcomposer.org/download/
## Pull code
```bash
git clone https://github.com/uit2712/english-laravel
```
## Create file .env
Copy content of file __.env.example__
## Run web by command below
```sh
cd ./docker && up.sh
```
# Migrate and seed data
```sh
composer migrate:seed
```
# Browse url http://localhost:8000/api/documentation to show all available api
# Run tests
```bash
composer test
```
