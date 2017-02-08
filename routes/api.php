<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/authenticate', [
	'as' => 'authenticate',
	'uses' => 'AuthenticateController@authenticate'
]);

Route::group(['prefix' => 'sources', 'middleware' => 'jwt.auth'], function() {
  require __DIR__.'/resources/sources.php';
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
