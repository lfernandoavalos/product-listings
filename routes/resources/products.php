<?php

Route::get('/', [
	'as' => 'products.index',
	'uses' => 'ProductController@index'
]);