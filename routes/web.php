<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BuildReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\IncomeExpenseAccountController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesOrderTypeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesInvoice\AllController;
use App\Http\Controllers\SalesInvoice\CancelledController;
use App\Http\Controllers\SalesInvoice\ForInvoicingController;
use App\Http\Controllers\SalesInvoice\ForValidationController;
use App\Http\Controllers\SalesInvoice\ForPostingController;
use App\Http\Controllers\SalesInvoice\ReleasedController;
use App\Http\Controllers\SalesInvoiceAssignmentController;
use App\Http\Controllers\ShippingFeeController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\Tools\MaintainedMemberController;
use App\Http\Controllers\Tools\NucController;
use App\Http\Controllers\Tools\OriginController;
use App\Http\Controllers\Tools\PayloadController;
use App\Http\Controllers\TestBuildReportController;
use App\Http\Controllers\TransactionListingController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\Report\NucReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GateMiddleware;

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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth','gate'])->group(function () {
    
    Route::get('salesordertype_list', [SalesOrderTypeController::class, 'salesordertype_list'])->name('salesordertype_list');
   
    Route::get('sales_orders_list', [SalesController::class, 'sales_orders_list'])->name('sales_orders_list');
    Route::resource('sales-orders', SalesController::class);
    Route::resource('sales-invoice/for-invoice', ForInvoicingController::class);

    
    Route::group(['name' => 'sales-invoice', 'alias' => 'sales-invoice'], function() {
        Route::get('sales_invoice_list', [ForInvoicingController::class, 'sales_invoice_list'])->name('sales_invoice_list');
        Route::get('sales-invoice/for-invoice/{uuid}/print', [ForInvoicingController::class, 'print']);
        Route::resource('sales-invoice/for-invoice', ForInvoicingController::class);
        Route::get('sales_invoice_for_validation_list', [ForValidationController::class, 'sales_invoice_for_validation_list'])->name('sales_invoice_for_validation_list');
        Route::get('sales-invoice/for-validation/{uuid}/print', [ForInvoicingController::class, 'print']);
        Route::resource('sales-invoice/for-validation', ForValidationController::class);
        Route::resource('sales-invoice/for-posting', ForPostingController::class);
        Route::get('sales_invoice_released_list', [ReleasedController::class, 'sales_invoice_released_list'])->name('sales_invoice_released_list');
        Route::resource('sales-invoice/released', ReleasedController::class);
        Route::get('sales_invoice_cancel_list', [CancelledController::class, 'sales_invoice_cancel_list'])->name('sales_invoice_cancel_list');
        Route::resource('sales-invoice/cancelled', CancelledController::class);
        Route::get('sales_invoice_all_list', [AllController::class, 'sales_invoice_all_list'])->name('sales_invoice_all_list');
        Route::resource('sales-invoice/all', AllController::class);
    });


    // SUPPORT MODULES 
    Route::resource('branches', BranchController::class);
    Route::get('companies/sync-company', [CompanyController::class, 'sync_company']); // must be in api, use passport
    Route::resource('companies', CompanyController::class);
    Route::get('distributor_list', [DistributorController::class, 'distributor_list'])->name('distributor_list');
    Route::get('distributors/sync-distributors', [DistributorController::class, 'sync_distributors']); 
    Route::resource('distributors', DistributorController::class)->only('index');
    Route::get('items/sync-item', [ItemController::class, 'sync_item']); // must be in api, use passport
    Route::resource('items', ItemController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('sales-invoice-assignment', SalesInvoiceAssignmentController::class);
    Route::get('transaction-types/sync-transaction-type', [TransactionTypeController::class, 'sync_transaction_type']); // must be in api, use passport
    Route::resource('transaction-types', TransactionTypeController::class);
    Route::resource('income-expense-accounts', IncomeExpenseAccountController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', UserPermissionController::class)->only('edit','update');
    Route::resource('shipping-fee', ShippingFeeController::class);


    // REPORTS
    Route::group(['prefix' => 'reports', 'alias' => 'reports'], function() {
        Route::get('buildreport_list', [BuildReportController::class, 'buildreport_list'])->name('buildreport_list');
        Route::resource('build-report', BuildReportController::class)->only('index');
        Route::resource('logs', HistoryController::class);
        Route::get('stockcard_list', [StockCardController::class, 'stockcard_list'])->name('stockcard_list');
        Route::resource('stock-card', StockCardController::class)->only('index');
        Route::resource('transaction-listing', TransactionListingController::class)->only('index');
        Route::resource('nuc', NucReportController::class);
    });

    Route::get('test-build-report', [TestBuildReportController::class, 'testbuildreport'])->name('testbuildreport');
    Route::resource('test-build-report', TestBuildReportController::class)->only('index');


    // UPDATE PASSWORD
    Route::patch('update-password', [UserController::class, 'update_password'])->name('update-password');
});

// this is exclusive for super admim, no need for gate middleware
Route::middleware(['auth','superadmin'])->group(function () {
    Route::group(['prefix' => 'tools', 'name' => 'tools', 'alias' => 'tools'], function() {
        Route::get('maintained-members/sync', [MaintainedMemberController::class, 'sync']); // must be in api, use passport
        Route::resource('maintained-members', MaintainedMemberController::class)->only('index');
        Route::resource('nuc', NucController::class)->only('index');
        Route::resource('origins', OriginController::class)->only('index');
        Route::resource('payload', PayloadController::class)->only(['index', 'show']);
    });
});

// no gate
Route::middleware(['auth'])->group(function() {
    Route::put('update-payment-details/{uuid}', [ForValidationController::class, 'update_payment_details'])->name('update_payment_details');
});
