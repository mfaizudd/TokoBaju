<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductModelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [CustomerController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/products/{id}', [CustomerController::class, 'showProduct'])->name('product.show');
    Route::post('/products/{id}/addToCart', [CustomerController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
    Route::get('/cart/{id}/remove', [CustomerController::class, 'removeFromCart'])->name('cart.remove');

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function() {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('show');
        Route::get('/checkout/overview', [TransactionController::class, 'overview'])->name('overview');
        Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::prefix('admin')->middleware('auth.admin')->group(function() {

    Route::name('admin.')->group(function() {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('category', CategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::resource('product.model', ProductModelController::class);
    });
});

require __DIR__.'/auth.php';
