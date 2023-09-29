<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->controller((AuthenticationController::class))->group(function(){
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'authenticate');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/', [BusinessController::class, 'showAddNewBusiness']);
    Route::post('/', [BusinessController::class, 'addNewBusiness']);

    Route::get('/home', HomeController::class)->name('home');

    Route::get('/businesses', [BusinessController::class, 'getBusinesses'])->name('businesses');

    Route::post('/logout', [AuthenticationController::class, 'logOut']);
});
