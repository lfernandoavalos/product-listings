<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('products', function($table) {
            $table->integer('id');
            $table->increments('db_key_id');

            $table->string('title', 255);
            $table->mediumText('description');
            $table->double('price', [8, 2]);
            $table->string('source_url', 255);
            $table->string('source', 40);
            $table->mediumText('tags');
            $table->boolean('current')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('products');
    }
}
