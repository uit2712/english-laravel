# Install
## Install docker
## Pull code
## Create file .env
Copy content of file __.env.example__
## Run web by command below
```sh
cd ./docker && up.sh
```
## Install composer
# Migrate and seed data
```sh
composer migrate:seed
```
# Browse url http://localhost:8000/api/documentation to show all available api
# Run tests
```bash
composer test
```
