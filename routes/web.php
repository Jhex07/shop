<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/', [ProductController::class, 'home'])->name('products.home');
Route::get('/', [CategoryController::class, 'home'])->name('categories.home');


Route::group(['middleware' => ['auth']], function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'users', 'controller' => UserController::class], function (){
        Route::get('/', 'index')->name('users.index')->middleware('can:users.index');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/edit{user}', 'edit')->name('users.edit');
        Route::get('/show/{user}', 'show')->name('users.show');
        Route::put('/update/{user}', 'update')->name('users.update');
        Route::delete('/{user}', 'destroy')->name('users.destroy');
        Route::get('/get-roles', 'getRoles')->name('users.getRoles');
    });

    Route::group(['prefix' => 'products', 'controller' => ProductController::class], function () {
        Route::get('{product}', 'show')->name('products.show');
        Route::get('/', 'index')->name('products.index')->middleware('can:products.index');
        Route::post('/store', 'store')->name('products.store');
        Route::get('/edit{product}', 'edit')->name('products.edit');
        Route::post('/update/{product}', 'update')->name('products.update');
        Route::delete('/{product}', 'destroy')->name('products.destroy');
    });

    Route::group(['prefix' => 'categories', 'controller' => CategoryController::class], function (){
        Route::get('/', 'index')->name('categories.index')->middleware('can:categories.index');
        Route::get('/get-categories', 'getCategories')->name('products.getCategories');
        Route::get('/{category}', 'show')->name('categories.show');
        Route::post('/store', 'store')->name('categories.store')->middleware('can:categories.store');
        Route::post('/update/{category}', 'update')->name('categories.update')->middleware('can:categories.update');
        Route::delete('/{category}', 'destroy')->name('categories.destroy');

    });


});
