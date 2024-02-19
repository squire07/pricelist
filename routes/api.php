<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\BranchController;
use App\Http\Controllers\api\DistributorController;
use App\Http\Controllers\api\ErpNextController;
use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\ShippingFeeController;
use App\Http\Controllers\api\TransactionTypeController;
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
Route::get('distributor/maintained/{id}', [DistributorController::class, 'get_maintained_distributor_by_id']);

Route::get('item/transaction_type/{transaction_type_id}', [ItemController::class, 'get_item_by_transaction_type']);
Route::get('item/stock_by_warehouse/{item_id}/{branch_id}', [ItemController::class, 'get_stock_by_warehouse']);
Route::get('item/{id}', [ItemController::class, 'get_item_by_id']);
Route::get('item/bundle/{bundle_code}', [ItemController::class, 'get_item_bundle']);
Route::get('shippingfee/{id}', [ShippingFeeController::class, 'get_shippingfee_by_id']);
Route::get('transaction_type/is_upc_ubc/{id}', [TransactionTypeController::class, 'is_upc_ubc_transaction']);
Route::get('branches_by_cashiers_id/{cashiers_id}/{auth_user_id}', [BranchController::class, 'get_branches_by_cashiers_id']);

Route::post('permission', [PermissionController::class, 'user_permission']);

Route::post('cancel-invoice', [ErpNextController::class, 'cancel_invoice']);