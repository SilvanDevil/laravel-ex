<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('home/{id}', 'Testtest@info');
Route::get('query', 'MysqlController@query');
Route::get('test', 'MysqlController@test');
Route::get('weixin/api', 'WeixinController@api');
Route::post('weixin/api', 'WeixinController@api');
