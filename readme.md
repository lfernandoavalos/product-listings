<p align="center"><img src="https://facturama.mx/Public/img/clients_img/konfio-facturama-factura-electronica-gratis.png"></p>


## Product Listings

Product listings api built with [Laravel](https://laravel.com).

## Key Features
Product records are stored as temporal records in order to keep product history

## Todo
- Implement ElasticSearch
- Implement search




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

`php -S localhost:8000 public/index.php`

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
    --url 'http://localhost:8000/api/sources/linio/scrape?token=[YOUR_TOKEN]&search=zapatos' \
    --header 'cache-control: no-cache' \

We can view our products

    curl --request GET \
    --url 'http://localhost:8000/api/products?token=[YOUR_TOKEN]' \
    --header 'cache-control: no-cache' \

Due to timeout if you want to scrape more than 10 items please use artisan command

`php artisan scrape:sources [Search Term] --source=[linio|mercado_libre] --limit=[YOUR_LIMIT]`

## List of endpoints

Please review routes.txt