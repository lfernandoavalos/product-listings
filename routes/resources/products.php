<?php

Route::get('/', [
	'as' => 'products.index',
	'uses' => 'ProductController@index'
]);

Route::get('{id}', [
	'as' => 'products.show',
	'uses' => 'ProductController@show'
]);

Route::get('{id}/history', [
	'as' => 'products.history',
	'uses' => 'ProductController@history'
]);