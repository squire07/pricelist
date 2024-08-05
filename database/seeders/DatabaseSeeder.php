<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AreaGroups;
use App\Models\CustomerCategories;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BranchSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(PermissionModuleSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserPermissionSeeder::class);
        $this->call(CustomerCategorySeeder::class);
        $this->call(CustomerAreaGroupSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ProductsCategorySeeder::class);
        $this->call(SupplierSeeder::class);
        // $this->call(EmployeeSeeder::class);
        // $this->call(EmployeeDetailsSeeder::class);
        $this->call(AgentCategoriesSeeder::class);
        $this->call(DepartmentSeeder::class);
        // $this->call(ProductsSeeder::class);
        $this->call(CheckStatusSeeder::class);
        $this->call(DeliveryStatusSeeder::class);
        $this->call(PaymentStatusSeeder::class);
        $this->call(PaymentTermsSeeder::class);
        $this->call(SrpTypesSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(BarangaySeeder::class);
    }
}
