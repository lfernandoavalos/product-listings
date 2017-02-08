<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	echo "php artisan db:seed --class=UsersTableSeeder\n";
        // $this->call(UsersTableSeeder::class);
    }
}
