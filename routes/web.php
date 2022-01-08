<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NumberController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('numbers', NumberController::class);
    Route::get('customer-numbers/{id}' , [NumberController::class, 'numbers'])->name('customer.numbers');
    Route::post('list-numbers/{id}' , [NumberController::class, 'listNumbers'])->name('list.numbers');
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
