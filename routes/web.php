<?php

use App\Http\Controllers\BuildReportController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesOrderTypeController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\TestBuildReportController;
use App\Http\Controllers\TransactionListingController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesInvoice\AllController;
use App\Http\Controllers\SalesInvoice\CancelledController;
use App\Http\Controllers\SalesInvoice\ForInvoicingController;
use App\Http\Controllers\SalesInvoice\ReleasedController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RoleController;

use App\Models\SalesInvoiceCancel;
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

Route::middleware('auth')->group(function () {
    // json 
    Route::get('distributor_list', [DistributorController::class, 'distributor_list'])->name('distributor_list');
    Route::resource('distributor', DistributorController::class)->only('index');
    Route::get('salesordertype_list', [SalesOrderTypeController::class, 'salesordertype_list'])->name('salesordertype_list');
    Route::resource('salesordertype', SalesOrderTypeController::class)->only('index');
    Route::get('transactionlisting_list', [TransactionListingController::class, 'transactionlisting_list'])->name('transactionlisting_list');
    Route::resource('transactionlisting', TransactionListingController::class)->only('index');
    Route::get('buildreport_list', [BuildReportController::class, 'buildreport_list'])->name('buildreport_list');
    Route::resource('buildreport', BuildReportController::class)->only('index');
    Route::get('stockcard_list', [StockCardController::class, 'stockcard_list'])->name('stockcard_list');
    Route::resource('stockcard', StockCardController::class)->only('index');
    Route::resource('Item', ItemController::class);
    Route::resource('/item', ItemController::class);


    // json 
    Route::get('sales_orders_list', [SalesController::class, 'sales_orders_list'])->name('sales_orders_list');
    Route::resource('sales-orders', SalesController::class);
    Route::resource('sales-invoice/for-invoice', ForInvoicingController::class);

    Route::group(['name' => 'sales-invoice', 'alias' => 'sales-invoice'], function() {
        Route::get('sales_invoice_list', [ForInvoicingController::class, 'sales_invoice_list'])->name('sales_invoice_list');
        Route::resource('sales-invoice/for-invoice', ForInvoicingController::class);

        Route::get('sales_invoice_released_list', [ReleasedController::class, 'sales_invoice_released_list'])->name('sales_invoice_released_list');
        Route::resource('sales-invoice/released', ReleasedController::class);
        

        Route::get('sales_invoice_cancel_list', [CancelledController::class, 'sales_invoice_cancel_list'])->name('sales_invoice_cancel_list');
        Route::resource('sales-invoice/cancelled', CancelledController::class);
        
        Route::get('sales_invoice_all_list', [AllController::class, 'sales_invoice_all_list'])->name('sales_invoice_all_list');
        Route::resource('sales-invoice/all', AllController::class);
    });

    Route::resource('branches', BranchController::class);
    Route::resource('roles', RoleController::class);



    Route::get('testbuildreport', [TestBuildReportController::class, 'testbuildreport'])->name('testbuildreport');
    Route::resource('testbuildreport', TestBuildReportController::class)->only('index');


    
});