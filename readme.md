<p align="center"><img src="https://facturama.mx/Public/img/clients_img/konfio-facturama-factura-electronica-gratis.png"></p>


## Product Listings

Product listings api built with [Laravel](https://laravel.com)


## Before you begin

Make sure you have [Composer](https://getcomposer.org/) installed


## Setup
Run `composer install`

Copy our example env file

`cp .env.example .env`

Update `.env` file with your own configuration


    APP_URL=http://localhost:8000
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=product_listings
    DB_USERNAME=root
    DB_PASSWORD=root

Run migration files

`php artisan migrate`

Run our seeder

`php artisan db:seed --class=UsersTableSeeder`

Run our php server

`php -S localhost:8000 plic/index.php`

## Usage
First we need to create our access token

    curl --request POST \
    --url http://localhost:8000/api/authenticate \
    --header 'cache-control: no-cache' \
    --header 'content-type: application/x-www-form-urlencoded' \
    --data 'email=lfernandoavalos%40gmail.com&password=password'

Now we can post to our sources

We currently have 2 sources
`/api/sources/linio/scrape` & `/api/sources/mercado_libre/scrape`

    curl --request POST \
    --url 'http://localhost:8000/api/sources/linio/scrape?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTQ4NjU5NzMzNSwiZXhwIjoxNDg2NjAwOTM1LCJuYmYiOjE0ODY1OTczMzUsImp0aSI6IjliYTBkMzE3NWE4YjEwMWE4OTcwMzllZDBkOWNiNGYwIn0.66L-szZT9A3GwxCB8au-Y31dNjPFaGl0IhIdiSdIHOM&search=zapatos' \
    --header 'cache-control: no-cache' \

We can view our products

    curl --request GET \
    --url 'http://localhost:8000/api/products?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTQ4NjU5NzMzNSwiZXhwIjoxNDg2NjAwOTM1LCJuYmYiOjE0ODY1OTczMzUsImp0aSI6IjliYTBkMzE3NWE4YjEwMWE4OTcwMzllZDBkOWNiNGYwIn0.66L-szZT9A3GwxCB8au-Y31dNjPFaGl0IhIdiSdIHOM' \
    --header 'cache-control: no-cache' \

