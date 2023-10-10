<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DistributorController;
use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\ShippingFeeController;
use App\Http\Controllers\api\PermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('distributor/{id}', [DistributorController::class, 'get_distributor_by_id']);
Route::get('item/transaction_type/{id}', [ItemController::class, 'get_item_by_transaction_type']);
Route::get('item/{id}', [ItemController::class, 'get_item_by_id']);
Route::get('shippingfee/{id}', [ShippingFeeController::class, 'get_shippingfee_by_id']);

Route::post('permission', [PermissionController::class, 'user_permission']);

