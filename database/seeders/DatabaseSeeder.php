<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\DistributorSeeder;
use Database\Seeders\ItemSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\TransactionTypeSeeder;
use Database\Seeders\UserSeeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'uuid' => '7febda16-1893-4084-be0f-99f81514ab99',
            'name' => 'Aris Flores',
            'username' => 'aris',
            'email' => 'test1234@test.com',
            'password' => Hash::make('12345678'),
            'created_by' => 'System',
            'updated_by' => 'System'
        ]);

        \App\Models\User::factory()->create([
            'uuid' => 'a1872ec9-9cf5-4257-82e6-d97a3d77fa5f',
            'name' => 'Test User',
            'username' => 'test',
            'email' => 'test@test.com',
            'password' => Hash::make('12345678'),
            'created_by' => 'System',
            'updated_by' => 'System'
        ]);

        $this->call(BranchSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(DistributorSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TransactionTypeSeeder::class);
        $this->call(UserSeeder::class);

        // dummy data only
        $this->call(ItemSeeder::class);
    }
}
