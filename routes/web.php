<?php

use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesOrderTypeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// json 
Route::get('distributor_list', [DistributorController::class, 'distributor_list'])->name('distributor_list');
Route::resource('distributor', DistributorController::class)->only('index');

Route::resource('Item', ItemController::class);
Route::resource('/item', ItemController::class);
Route::resource('SalesOrderType', SalesOrderTypeController::class);
Route::resource('/salesordertype', SalesOrderTypeController::class);
