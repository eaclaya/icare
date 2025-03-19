# Project Setup Instructions

## Using Laravel Herd + Docker

1. Move the project folder to the Herd folder.
2. Copy `.env.example` to `.env`.
3. Run `composer install`.
4. Run `php artisan key:generate`.
5. Run `docker compose up -d`.
6. Run `php artisan migrate`.
7. Run `php artisan app:create-user`
8. Run `php artisan db:seed`
9. Open [http://icare.test](http://icare.test) and log in with the user credentials from the previous step.

## Using Docker Only

1. Copy `.env.example` to `.env`.
2. Uncomment the `nginx` service in `docker-compose.yml`.
3. Run `composer install`.
4. Run `php artisan key:generate`.
5. Run `docker compose up -d`.
6. Run `docker compose exec app php artisan migrate`.
7. Run `docker compose exec app php artisan app:create-user`
8. Run `php artisan db:seed`
9. Open [http://icare.test](http://icare.test) and log in with the user credentials from the previous step.

### Additional Configuration

-   Add `icare.test` to your `/etc/hosts`.
-   Run `php artisan db:seed --class=DemoSeeder` to seed dummy data
