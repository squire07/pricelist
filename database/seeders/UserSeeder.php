<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            1 => array('name' => 'Redemption Local', 'username' => 'redemptionlocal', 'role_id' => 1, 'branch_id' => 1, 'company_id' => 1),
            2 => array('name' => 'Redemption Premier', 'username' => 'redemptionpremier', 'role_id' => 1, 'branch_id' => 7, 'company_id' => 2),
            3 => array('name' => 'Redemption Baguio', 'username' => 'redemptionbaguio', 'role_id' => 1, 'branch_id' => '4,10', 'company_id' => '1,2'),

            4 => array('name' => 'Cashier Local', 'username' => 'cashierlocal', 'role_id' => 2, 'branch_id' => 1, 'company_id' => 1),
            5 => array('name' => 'Cashier Premier', 'username' => 'cashierpremier', 'role_id' => 2, 'branch_id' => 7, 'company_id' => 2),
            6 => array('name' => 'Cashier Baguio', 'username' => 'cashierbaguio', 'role_id' => 2, 'branch_id' => '4,10', 'company_id' => '1,2'),

            7 => array('name' => 'Head Redemption Local', 'username' => 'headredemptionlocal', 'role_id' => 3, 'branch_id' => 1, 'company_id' => 1),
            8 => array('name' => 'Head Redemption Premier', 'username' => 'headredemptionpremier', 'role_id' => 3, 'branch_id' => 7, 'company_id' => 2),
            9 => array('name' => 'Head Redemption Baguio', 'username' => 'headredemptionbaguio', 'role_id' => 3, 'branch_id' => '4,10', 'company_id' => '1,2'),

            10 => array('name' => 'Head Cashier Local', 'username' => 'headcashierlocal', 'role_id' => 4, 'branch_id' => 1, 'company_id' => 1),
            11 => array('name' => 'Head Cashier Premier', 'username' => 'headcashierpremier', 'role_id' => 4, 'branch_id' => 7, 'company_id' => 2),
            12 => array('name' => 'Head Cashier Baguio', 'username' => 'headcashierbaguio', 'role_id' => 4, 'branch_id' => '4,10', 'company_id' => '1,2'),

            13 => array('name' => 'Officer In Charge Local', 'username' => 'oiclocal', 'role_id' => 5, 'branch_id' => 1, 'company_id' => 1),
            14 => array('name' => 'Officer In Charge Premier', 'username' => 'oicpremier', 'role_id' => 5, 'branch_id' => 7, 'company_id' => 2),
            15 => array('name' => 'Officer In Charge Baguio', 'username' => 'oicbaguio', 'role_id' => 5, 'branch_id' => '4,10', 'company_id' => '1,2'),

            16 => array('name' => 'Branch Manger Local', 'username' => 'branchmanagerlocal', 'role_id' => 6, 'branch_id' => 1, 'company_id' => 1),   
            17 => array('name' => 'Branch Manger Premier', 'username' => 'branchmanagerpremier', 'role_id' => 6, 'branch_id' => 7, 'company_id' => 2),
            18 => array('name' => 'Branch Manger Baguio', 'username' => 'branchmanagerbaguio', 'role_id' => 6, 'branch_id' => '4,10', 'company_id' => '1,2'),

            19 => array('name' => 'Viewer', 'username' => 'viewer', 'role_id' => 7, 'branch_id' => NULL, 'company_id' => NULL),
            20 => array('name' => 'Viewer Local', 'username' => 'viewerlocal', 'role_id' => 7, 'branch_id' => 1, 'company_id' => 1),
            21 => array('name' => 'Viewer Premier', 'username' => 'viewerpremier', 'role_id' => 7, 'branch_id' => 7, 'company_id' => 2),
            22 => array('name' => 'Accounting', 'username' => 'accounting', 'role_id' => 8, 'branch_id' => NULL, 'company_id' => NULL),
            23 => array('name' => 'Treasury', 'username' => 'treasury', 'role_id' => 9, 'branch_id' => NULL, 'company_id' => NULL),
            24 => array('name' => 'Manager Local', 'username' => 'managerlocal', 'role_id' => 10, 'branch_id' => 1, 'company_id' => 1),
            25 => array('name' => 'Manager Premier', 'username' => 'managerpremier', 'role_id' => 10, 'branch_id' => 7, 'company_id' => 2),
            26 => array('name' => 'Manager Ecomm', 'username' => 'managerecomm', 'role_id' => 10, 'branch_id' => NULL, 'company_id' => NULL),
            27 => array('name' => 'Administrator', 'username' => 'administrator', 'role_id' => 11, 'branch_id' => NULL, 'company_id' => NULL),
            28 => array('name' => 'Superadmin', 'username' => 'superadmin', 'role_id' => 12, 'branch_id' => NULL, 'company_id' => NULL),
        ];

        foreach($users as $key => $user) {
            User::create([
                'uuid' => Str::uuid(),
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['username'] . '@glv2.com',
                'password' => Hash::make('12345678'),
                'role_id' => $user['role_id'],
                'branch_id' => $user['branch_id'],
                'company_id' => $user['company_id'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
