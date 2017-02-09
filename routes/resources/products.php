<?php

Route::get('/', [
	'as' => 'products.index',
	'uses' => 'ProductController@index'
]);

Route::get('{id}', [
	'as' => 'products.show',
	'uses' => 'ProductController@show'
]);