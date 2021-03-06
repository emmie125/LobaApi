<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonTrustController;
use App\Http\Controllers\Auth\RegisterController;



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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('signup', 'AuthController@signup');
    Route::post('login', 'AuthController@login');
});
Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
    // Route::get('/person_trusts', 'PersonTrustController@index');
    Route::get('create_alert', 'AlerteController@createAlert');
    Route::apiResource('/person_trusts', 'PersonTrustController');
    Route::apiResource('/type_conseils', 'TypeConseilController');
    Route::apiResource('/conseils', 'ConseilController');
    Route::apiResource('/likes', 'LikeController');
});
