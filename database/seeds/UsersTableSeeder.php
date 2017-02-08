<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            DB::table('users')->insert([
                'name' => 'Fernando Avalos',
                'email' => 'lfernandoavalos@gmail.com',
                'password' => bcrypt('password'),
            ]);
        }catch(\Exception $e) {}
    }
}