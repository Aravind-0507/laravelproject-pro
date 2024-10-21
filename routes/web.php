<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Models\Stock;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('home', [LoginController::class, 'home'])->name('home');
Route::post('login', [LoginController::class, 'login']);

Route::get('Welcome', [WelcomeController::class, 'index'])->name('Welcome');

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

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


// Route::post('stocks/assign', [StockController::class, 'assign'])->name('stocks.assign');
// Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index'); 
// Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store'); 
// Route::post('/stocks/create', [StockController::class, 'create'])->name('stocks.create'); 
// Route::post('/stocks/edit', [StockController::class, 'edit'])->name('stocks.edit'); 
// Route::post('/stocks/destroy', [StockController::class, 'delete'])->name('stocks.destroy'); 

Route::resource('stocks', StockController::class);


Route::get('users/{user}/assign-stocks', [StockController::class, 'assignStocks'])
    ->name('stocks.assign');

Route::post('users/{user}/assign-stocks', [StockController::class, 'storeAssignedStocks'])
    ->name('stocks.storeAssignedStocks');

    Route::get('stocks/assign/{user}', [StockController::class, 'showAssignStocks'])->name('stocks.assign');
    
    Route::get('/users/{user}/assign-stocks', [StockController::class, 'assignStocksToUser'])
    ->name('stocks.assign');