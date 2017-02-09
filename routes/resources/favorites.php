<?php

// List all favorite resources
Route::get('', [
	'as' => 'favorites.index',
	'uses' => 'FavoriteController@index'
]);

// Store new favorite
Route::post('', [
	'as' => 'favorites.store',
	'uses' => 'FavoriteController@store'
]);

// Display favorite information
Route::get('{id}', [
	'as' => 'favorites.show',
	'uses' => 'FavoriteController@show'
]);

// Delete favorite
Route::delete('{id}', [
	'as' => 'favorites.delete',
	'uses' => 'FavoriteController@delete'
]);