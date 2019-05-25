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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('companies', 'CompanyController@index');
    Route::get('companies/{company}', 'CompanyController@show');
    Route::get('companies/tree/{company}', 'CompanyController@tree');
    Route::post('companies', 'CompanyController@store');
    Route::put('companies/{company}', 'CompanyController@update');
    Route::delete('companies/{company}', 'CompanyController@delete');
    Route::get('stations', 'StationController@index');
    Route::get('stations/{station}', 'StationController@show');
    Route::get('radius', 'StationController@radius');
    Route::post('stations', 'StationController@store');
    Route::put('stations/{station}', 'StationController@update');
    Route::delete('stations/{station}', 'StationController@delete');
});
