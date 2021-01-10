<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
  Route::post('signup', 'App\Http\Controllers\UserController@register');
  Route::post('signin', 'App\Http\Controllers\UserController@authenticate');

  Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('users', 'App\Http\Controllers\UserController@all');
    Route::put('users/inactive', 'App\Http\Controllers\UserController@inactiveUsers');
    Route::post('users/random', 'App\Http\Controllers\UserController@generateRandomUsers');

    Route::group(['prefix' => 'todo'], function() {
      Route::post('', 'App\Http\Controllers\TodoController@store');
      Route::get('', 'App\Http\Controllers\TodoController@index');
      Route::put('{todo_id}', 'App\Http\Controllers\TodoController@update');
    });
  });
});
