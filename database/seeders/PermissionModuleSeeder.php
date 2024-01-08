<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\PermissionModule;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            1 => array('name' => 'Sales Orders', 'type' => 'module', 'controller' => 'SalesController', 'redirect' => 'sales-orders', 'sequence' => 1),
            2 => array('name' => 'Sales Invoice - For Invoice', 'type' => 'module', 'controller' => 'ForInvoicingController', 'redirect' => 'sales-invoice/for-invoice', 'sequence' => 2),
            3 => array('name' => 'Sales Invoice - Released', 'type' => 'module', 'controller' => 'ReleasedController', 'redirect' => 'sales-invoice/released', 'sequence' => 5),
            4 => array('name' => 'Sales Invoice - For Validation', 'type' => 'module', 'controller' => 'ForValidationController', 'redirect' => 'sales-invoice/for-validation', 'sequence' => 3),
            5 => array('name' => 'Sales Invoice - Cancelled', 'type' => 'module', 'controller' => 'CancelledController', 'redirect' => 'sales-invoice/cancelled', 'sequence' => 6),
            6 => array('name' => 'Sales Invoice - All', 'type' => 'module', 'controller' => 'AllController', 'redirect' => 'sales-invoice/all', 'sequence' => 7),
            7 => array('name' => 'Branches', 'type' => 'module', 'controller' => 'BranchController', 'redirect' => 'branches', 'sequence' => 8),
            8 => array('name' => 'Companies', 'type' => 'module', 'controller' => 'CompanyController', 'redirect' => 'companies', 'sequence' => 9),
            9 => array('name' => 'Distributors', 'type' => 'module', 'controller' => 'DistributorController', 'redirect' => 'distributors', 'sequence' => 10),
            10 => array('name' => 'Items', 'type' => 'module', 'controller' => 'ItemController', 'redirect' => 'items', 'sequence' => 12),
            11 => array('name' => 'Roles', 'type' => 'module', 'controller' => 'RoleController', 'redirect' => 'roles', 'sequence' => 14),
            12 => array('name' => 'Sales Invoice Assignment', 'type' => 'module', 'controller' => 'SalesInvoiceAssignmentController', 'redirect' => 'sales-invoice-assignment', 'sequence' => 15),
            13 => array('name' => 'Transaction Types', 'type' => 'module', 'controller' => 'TransactionTypeController', 'redirect' => 'transaction-types', 'sequence' => 17),
            14 => array('name' => 'Payment Method', 'type' => 'module', 'controller' => 'PaymentMethodController', 'redirect' => 'payment-method', 'sequence' => 13),
            15 => array('name' => 'Users', 'type' => 'module', 'controller' => 'UserController', 'redirect' => 'users', 'sequence' => 19),
            16 => array('name' => 'User Permission', 'type' => 'module', 'controller' => 'UserPermissionController', 'redirect' => 'permissions', 'sequence' => 18),
            
            17 => array('name' => 'Build Report', 'type' => 'report', 'controller' => 'BuildReportController', 'redirect' => 'reports/build-report', 'sequence' => 20),
            18 => array('name' => 'Logs', 'type' => 'report', 'controller' => 'HistoryController', 'redirect' => 'reports/logs', 'sequence' => 21),
            19 => array('name' => 'Stock Card', 'type' => 'report', 'controller' => 'StockCardController', 'redirect' => 'reports/stock-card', 'sequence' => 23),
            20 => array('name' => 'Transaction Listing', 'type' => 'report', 'controller' => 'TransactionListingController', 'redirect' => 'reports/transaction-listing', 'sequence' => 24),

            21 => array('name' => 'Shipping Fee', 'type' => 'module', 'controller' => 'ShippingFeeController', 'redirect' => 'shipping-fee', 'sequence' => 16),
            22 => array('name' => 'Income Expense Account', 'type' => 'module', 'controller' => 'IncomeExpenseAccountController', 'redirect' => 'income-expense-accounts', 'sequence' => 11),
            23 => array('name' => 'Sales Invoice - For Posting', 'type' => 'module', 'controller' => 'ForPostingController', 'redirect' => 'sales-invoice/for-posting', 'sequence' => 4),
            24 => array('name' => 'NUC Report', 'type' => 'report', 'controller' => 'ForPostingController', 'redirect' => 'reports/nuc', 'sequence' => 22),
        ];

        foreach($modules as $key => $module) {
            PermissionModule::create([
                'uuid' => Str::uuid(),
                'name' => $module['name'],
                'type' => $module['type'],
                'controller' => $module['controller'],
                'redirect' => $module['redirect'],
                'sequence' => $module['sequence'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }

    
}
