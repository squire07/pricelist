<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call(DistributorSeeder::class);
        $this->call(MaintainedMemberSeeder::class);
        $this->call(OriginSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(PermissionModuleSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ShippingFeeSeeder::class); 
        $this->call(StatusSeeder::class);
        $this->call(TransactionTypeSeeder::class);
        $this->call(UserSeeder::class);

        // dummy data only
        $this->call(ItemSeeder::class);
    }
}
