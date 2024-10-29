<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UsersController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('home', [LoginController::class, 'home'])->name('home');
Route::post('login', [LoginController::class, 'login']);

Route::get('Welcome', [WelcomeController::class, 'index'])->name('Welcome');

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/export-excel', [ExportController::class, 'exportToExcel'])->name('export.excel');


Route::get('password/request', [PasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{id}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordController::class, 'reset'])->name('password.update');

Route::post('', [WelcomeController::class, 'logout'])->name('logout');

Route::get('password/expired', function () {
    return view('auth.passwords.expired');
})->name('password.expired');

Route::post('stocks/assign', [StockController::class, 'assign'])->name('stocks.assign');
Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store');
Route::post('/stocks/create', [StockController::class, 'create'])->name('stocks.create');
Route::post('/stocks/edit', [StockController::class, 'edit'])->name('stocks.edit');
Route::post('/stocks/destroy', [StockController::class, 'delete'])->name('stocks.destroy');

Route::resource('stocks', StockController::class);


Route::get('users/{user}/assign-stocks', [StockController::class, 'assignStocks'])
    ->name('stocks.assign');

Route::post('users/{user}/assign-stocks', [StockController::class, 'storeAssignedStocks'])
    ->name('stocks.storeAssignedStocks');

Route::get('stocks/assign/{user}', [StockController::class, 'showAssignStocks'])->name('stocks.assign');

Route::get('/users/{user}/assign-stocks', [StockController::class, 'assignStocksToUser'])
    ->name('stocks.assign');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/home', [LoginController::class, 'home'])->name('home');


Route::get('users/{user}/assign-stocks/{stockId}', [UsersController::class, 'assignStocks'])->name('users.assign_stocks');
Route::post('/users/{user}/store-stock', [UsersController::class, 'storeStock'])->name('users.store_stock');
Route::get('/users/{user}/assign-stock', [UsersController::class, 'showAssignStockForm'])->name('users.assign_stocks');
Route::get('/user/menu', [UsersController::class, 'menu'])->name('users.menu');