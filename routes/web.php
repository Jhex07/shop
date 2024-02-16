<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
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
Route::get('product/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('categories.show');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'users', 'controller' => UserController::class], function () {
        Route::get('/', 'index')->name('users.index')->middleware('can:users.index');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/edit{user}', 'edit')->name('users.edit');
        Route::get('/show/{user}', 'show')->name('users.show');
        Route::put('/update/{user}', 'update')->name('users.update');
        Route::delete('/{user}', 'destroy')->name('users.destroy');
        Route::get('/get-roles', 'getRoles')->name('users.getRoles');
    });

    Route::group(['prefix' => 'products', 'controller' => ProductController::class], function () {

        Route::post('/store', 'store')->name('products.store')->middleware('can:products.store');
        Route::get('/{id}', 'show')->name('product.detail');
        Route::get('/', 'index')->name('products.index')->middleware('can:products.index');
        Route::post('/update/{product}', 'update')->name('products.update')->middleware('can:products.index');
        Route::delete('/{product}', 'destroy')->name('products.destroy')->middleware('can:products.index');
    });

    Route::group(['prefix' => 'categories', 'controller' => CategoryController::class], function () {
        Route::get('/', 'index')->name('categories.index')->middleware('can:categories.index');
        Route::get('/get-categories', 'getCategories')->name('products.getCategories');
        Route::post('/store', 'store')->name('categories.store')->middleware('can:categories.store');
        Route::put('/update/{category}', 'update')->name('categories.update')->middleware('can:categories.update');
        Route::delete('/{category}', 'destroy')->name('categories.destroy');
    });


    Route::group(['prefix' => 'cart', 'controller' => CartController::class], function () {
        Route::post('/store', 'store')->name('cart.store');
        Route::put('/cart/{cartProduct}', [CartController::class, 'update'])->name('cart.update');
        Route::get('/show', 'show')->name('cart.show');
        Route::get('/items', 'getCartItems')->name('cart.items');
        Route::delete('items/{productId}', 'removeFromCart')->name('cart.removeFromCart');
       

    });
});
