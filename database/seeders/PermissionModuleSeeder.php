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
            1 => array('name' => 'Sales Orders', 'type' => 'module', 'controller' => 'SalesController'),
            2 => array('name' => 'Sales Invoice - For Invoice', 'type' => 'module', 'controller' => 'ForInvoicingController'),
            3 => array('name' => 'Sales Invoice - Released', 'type' => 'module', 'controller' => 'ReleasedController'),
            4 => array('name' => 'Sales Invoice - For Validation', 'type' => 'module', 'controller' => 'ForValidationController'),
            5 => array('name' => 'Sales Invoice - Cancelled', 'type' => 'module', 'controller' => 'CancelledController'),
            6 => array('name' => 'Sales Invoice - All', 'type' => 'module', 'controller' => 'AllController'),
            7 => array('name' => 'Branches', 'type' => 'module', 'controller' => 'BranchController'),
            8 => array('name' => 'Companies', 'type' => 'module', 'controller' => 'CompanyController'),
            9 => array('name' => 'Distributors', 'type' => 'module', 'controller' => 'DistributorController'),
            10 => array('name' => 'Items', 'type' => 'module', 'controller' => 'ItemController'),
            11 => array('name' => 'Roles', 'type' => 'module', 'controller' => 'RoleController'),
            12 => array('name' => 'Sales Invoice Assignment', 'type' => 'module', 'controller' => 'SalesInvoiceAssignmentController'),
            13 => array('name' => 'Transaction Types', 'type' => 'module', 'controller' => 'TransactionTypeController'),
            14 => array('name' => 'Payment Types', 'type' => 'module', 'controller' => 'PaymentMethodController'),
            15 => array('name' => 'Build Report', 'type' => 'report', 'controller' => 'BuildReportController'),
            16 => array('name' => 'Logs', 'type' => 'report', 'controller' => 'ActivityLogController'),
            17 => array('name' => 'Stock Card', 'type' => 'report', 'controller' => 'StockCardController'),
            18 => array('name' => 'Transaction Listing', 'type' => 'report', 'controller' => 'TransactionListingController'),
        ];

        foreach($modules as $key => $module) {
            PermissionModule::create([
                'uuid' => Str::uuid(),
                'name' => $module['name'],
                'type' => $module['type'],
                'controller' => $module['controller'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }

    
}
