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
Route::group([ 'prefix' => '/auth'], 
 function () {

Route::post('/login', 'AuthController@login');

Route::post('/register', 'AuthController@register');

Route::put('/updatename/{id}', 'AuthController@updatename');
Route::put('/updateaddress/{id}', 'AuthController@updateaddress');
Route::put('/updatedevice/{id}', 'AuthController@updatedevice');
Route::delete('/delete/{id}','AuthController@delete');

}); 

 


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
