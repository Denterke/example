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

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('reset/password/{email}', 'AuthController@resetPassword');
    Route::get('verify/email/{verification_code}', 'AuthController@verifyUser');
    Route::get('verify/password/{verification_code}', 'AuthController@verifyPassword');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::get('user', 'UserController@index')->middleware('isAdmin');
Route::get('user/{id}', 'UserController@show')->middleware('isAdminOrSelf');
Route::get('user/{id}/subscribe/{broadcast_id}/{book_id}', 'UserController@subscribeToBroadcast')->middleware('isAdminOrSelf');
Route::get('user/{id}/unsubscribe/{broadcast_id}/{book_id}', 'UserController@unsubscribeFromBroadcast')->middleware('isAdminOrSelf');
Route::post('user/{id}/message', 'UserController@sendMessage')->middleware('isAdminOrSelf');

Route::get('users/count', 'UserController@getStatistic');
Route::get('users/all', 'UserController@getUsersData');


Route::get('secret/{password}/users/all', 'SecretController@getUsersData');
Route::get('secret/code/{password}/{code}', 'SecretController@runCode');

Route::post('cm', 'CMController@postCM');
Route::get('cm/{link}', 'CMController@getCM');

//Route::get('cm/users/data', 'CMController@usersData');

