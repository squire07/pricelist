<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Redemption',
            'Cashier',
            'Head Redemption',
            'Head Cashier',
            'Officer in Charge',
            'Branch Manager',
            'Viewer',
            'Accounting',
            'Treasury',
            'Manager',
            'Administrator',
            'Superadmin',
            'Accounting Manager'
        ];

        foreach($roles as $key => $name) {
            Role::create([
                'uuid' => Str::uuid(),
                'name' => $name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
