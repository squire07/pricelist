<?php

use App\Models\Suppliers;
use App\Models\Deliveries;
use App\Models\CustomerCategories;
use App\Models\TransactionListing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GateMiddleware;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\StockCardController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\Tools\NucController;
use App\Http\Controllers\AreaGroupsController;
use App\Http\Controllers\DeliveriesController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BuildReportController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ShippingFeeController;
use App\Http\Controllers\Tools\OriginController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\Tools\PayloadController;
use App\Http\Controllers\PurchaseOrdersController;
use App\Http\Controllers\SalesOrderTypeController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\TestBuildReportController;
use App\Http\Controllers\TransactionTypeController;
use App\Http\Controllers\Report\NucReportController;
use App\Http\Controllers\SalesInvoice\AllController;


use App\Http\Controllers\CustomerCategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryReportController;
use App\Http\Controllers\TransactionListingController;
use App\Http\Controllers\IncomeExpenseAccountController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentsDeliveryController;
use App\Http\Controllers\PaymentsExtractController;
use App\Http\Controllers\PaymentsOnlineController;
use App\Http\Controllers\PaymentsPhysicalController;
use App\Http\Controllers\SalesInvoice\ReleasedController;
use App\Http\Controllers\Report\StockCardReportController;
use App\Http\Controllers\SalesInvoice\CancelledController;
use App\Http\Controllers\SalesInvoiceAssignmentController;
use App\Http\Controllers\Tools\MaintainedMemberController;
use App\Http\Controllers\SalesInvoice\ForPostingController;
use App\Http\Controllers\SalesInvoice\ForInvoicingController;
use App\Http\Controllers\SalesInvoice\ForValidationController;

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
    
    Route::resource('dashboard', DashboardController::class);

    Route::resource('delivery-management', DeliveriesController::class);
    Route::get('delivery-management/{uuid}/print', [DeliveriesController::class, 'print']);
    Route::resource('purchase-orders', PurchaseOrdersController::class);

    Route::group(['name' => 'payments', 'alias' => 'payments'], function() {
        Route::get('payments/delivery/{uuid}/print', [PaymentsDeliveryController::class, 'print']);
        Route::resource('payments/delivery', PaymentsDeliveryController::class);
        Route::get('payments/delivery/{uuid}/edit-payment', [PaymentsDeliveryController::class, 'editPayment'])->name('payments.delivery.editPayment');
        Route::put('payments/delivery/{uuid}/update-payment', [PaymentsDeliveryController::class, 'updatePayment'])->name('payments.delivery.updatePayment');
       
        Route::get('payments/extract/{uuid}/print', [PaymentsExtractController::class, 'print']);
        Route::resource('payments/extract', PaymentsExtractController::class);

        Route::get('payments/online/{uuid}/print', [PaymentsOnlineController::class, 'print']);
        Route::resource('payments/online', PaymentsOnlineController::class);

        Route::get('payments/physical/{uuid}/print', [PaymentsPhysicalController::class, 'print']);
        Route::resource('payments/physical', PaymentsPhysicalController::class);
       
        Route::resource('payments/all', AllController::class);
    });

    
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
    Route::resource('area-groups', AreaGroupsController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('brands', BrandsController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('customers', CustomersController::class);
    Route::resource('customer-categories', CustomerCategoriesController::class);
    Route::resource('departments', DepartmentController::class);
    
    Route::resource('employees', EmployeesController::class);
    // Custom routes for fetching cities and barangays
    Route::get('get-cities/{province}', [EmployeesController::class, 'getCities'])->name('getCities');
    Route::get('get-barangays/{city}', [EmployeesController::class, 'getBarangays'])->name('getBarangays');
    
    Route::resource('products', ProductsController::class);
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('permissions', UserPermissionController::class)->only('edit','update');
    Route::resource('roles', RoleController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::resource('users', UserController::class);

    // Route for the product page with filtering
    Route::get('/products', [ProductsController::class, 'index'])->name('product.index');

    // Route for product details
    Route::get('/product/{id}', [ProductsController::class, 'show'])->name('product.details');


    // REPORTS
    Route::group(['prefix' => 'reports', 'alias' => 'reports'], function() {
        Route::resource('dr-report', DeliveryReportController::class)->only('index');
        Route::get('dr-report/generate', [DeliveryReportController::class, 'generate'])->name('generate-item-dr-report');
        Route::get('dr-report/generate-cafe', [DeliveryReportController::class, 'generateCafe'])->name('generate-cafe-item-dr-report');
        Route::get('dr-report/generate-marketing-materials', [DeliveryReportController::class, 'generateMarketingMaterials'])->name('generate-marketing-materials-report');
        Route::resource('transaction-listing', TransactionListingController::class)->only('index');
        Route::get('transaction-listing/generate', [TransactionListingController::class, 'generate'])->name('generate-transaction-list-report');
        Route::get('transaction-listing/generate-summary', [TransactionListingController::class, 'generateSummary'])->name('generate-summary-transaction-list-report');
        
        Route::resource('logs', HistoryController::class);
        Route::resource('nuc', NucReportController::class);
        Route::get('stock-card', [StockCardReportController::class, 'index']);
        Route::get('stock-card/generate', [StockCardReportController::class, 'generate'])->name('generate-stock-card-report');
        Route::get('stock-card/download/{filename}', [StockCardReportController::class, 'download']);
        
    });

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