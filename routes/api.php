<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthUserAPIController;

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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

Route::post('/login', [AuthUserAPIController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('/profile', [AuthUserAPIController::class, 'profile']);
    Route::post('/logout', [AuthUserAPIController::class, 'logout']);

    Route::group(['prefix' => 'users', 'controller' => UserController::class], function(){
        Route::get('/', 'index');
        Route::get('/{user}', 'show');
        Route::post('/', 'store');
        Route::put('/{user}', 'update');
        Route::delete('/{user}', 'destroy');

    });

    Route::group(['prefix' => 'products', 'controller' => ProductController::class], function(){
        Route::get('/', 'index');
        Route::get('/{product}', 'show');
        Route::post('/', 'store');
        Route::put('/{product}', 'update');
        Route::delete('/{product}', 'destroy');

    });

    Route::group(['prefix' => 'categories', 'controller' => CategoryController::class], function(){
        Route::get('/', 'index');
        Route::get('/{category}', 'show');
        Route::post('/', 'store');
        Route::put('/{category}', 'update');
        Route::delete('/{category}', 'destroy');
    });

});
