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
            1 => array('name' => 'Delivery Management', 'type' => 'Module', 'controller' => 'DeliveriesController', 'redirect' => 'delivery-management', 'sequence' => 1),
            2 => array('name' => 'Purchase Order Management', 'type' => 'Module', 'controller' => 'PurchaseOrderController', 'redirect' => 'purchase-orders', 'sequence' => 2),
            3 => array('name' => 'Sales Management', 'type' => 'Module', 'controller' => 'SalesController', 'redirect' => 'sales', 'sequence' => 3),
            4 => array('name' => 'Inventory Management', 'type' => 'Module', 'controller' => 'InventoryController', 'redirect' => 'inventory', 'sequence' => 4),
            5 => array('name' => 'Area Groups', 'type' => 'Module', 'controller' => 'AreaGroupsController', 'redirect' => 'area-groups', 'sequence' => 5),
            6 => array('name' => 'Customers', 'type' => 'Module', 'controller' => 'CustomerController', 'redirect' => 'customer', 'sequence' => 6),
            7 => array('name' => 'Customer Categories', 'type' => 'Module', 'controller' => 'CustomerCategoryController', 'redirect' => 'customer-categories', 'sequence' => 7),
            8 => array('name' => 'Employee Management', 'type' => 'Module', 'controller' => 'EmployeeController', 'redirect' => 'employees', 'sequence' => 8),
            9 => array('name' => 'Products', 'type' => 'Module', 'controller' => 'ProductController', 'redirect' => 'products', 'sequence' => 9), 
            10 => array('name' => 'Suppliers', 'type' => 'Module', 'controller' => 'SupplierCategoryController', 'redirect' => 'suppliers', 'sequence' => 10),
            11 => array('name' => 'Users', 'type' => 'Module', 'controller' => 'UserController', 'redirect' => 'users', 'sequence' => 11),
            12 => array('name' => 'Brands', 'type' => 'Module', 'controller' => 'BrandsController', 'redirect' => 'brands', 'sequence' => 12),
            13 => array('name' => 'Departments', 'type' => 'Module', 'controller' => 'DepartmentController', 'redirect' => 'departments', 'sequence' => 13),
            14 => array('name' => 'Roles', 'type' => 'Module', 'controller' => 'RoleController', 'redirect' => 'roles', 'sequence' => 14),
            15 => array('name' => 'DR Reports', 'type' => 'Report', 'controller' => 'DeliveryReportController', 'redirect' => 'reports/dr-report', 'sequence' => 15),
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
