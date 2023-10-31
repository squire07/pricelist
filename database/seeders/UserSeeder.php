<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\PermissionModule;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            1 => array('name' => 'Redemption West Local', 'username' => 'redemption_westlocal', 'role_id' => 1, 'branch_id' => 1, 'company_id' => 3),
            2 => array('name' => 'Redemption West Premier', 'username' => 'redemption_westpremier', 'role_id' => 1, 'branch_id' => 7, 'company_id' => 2),
            3 => array('name' => 'Redemption West', 'username' => 'redemption_west', 'role_id' => 1, 'branch_id' => '1,7', 'company_id' => '2,3'),
            4 => array('name' => 'Redemption Calamba Local', 'username' => 'redemption_calambalocal', 'role_id' => 1, 'branch_id' => 3, 'company_id' => 3),
            5 => array('name' => 'Redemption Calamba Premier', 'username' => 'redemption_calambapremier', 'role_id' => 1, 'branch_id' => 9, 'company_id' => 2),
            6 => array('name' => 'Redemption Calamba', 'username' => 'redemption_calamba', 'role_id' => 1, 'branch_id' => '3,9', 'company_id' => '2,3'),

            7 => array('name' => 'Cashier West Local', 'username' => 'cashier_westlocal', 'role_id' => 2, 'branch_id' => 1, 'company_id' => 3),
            8 => array('name' => 'Cashier West Premier', 'username' => 'cashier_westpremier', 'role_id' => 2, 'branch_id' => 7, 'company_id' => 2),
            9 => array('name' => 'Cashier West', 'username' => 'cashier_west', 'role_id' => 2, 'branch_id' => '1,7', 'company_id' => '2,3'),
            10 => array('name' => 'Cashier Calamba Local', 'username' => 'cashier_calambalocal', 'role_id' => 2, 'branch_id' => 3, 'company_id' => 3),
            11 => array('name' => 'Cashier Calamba Premier', 'username' => 'cashier_calambapremier', 'role_id' => 2, 'branch_id' => 9, 'company_id' => 2),
            12 => array('name' => 'Cashier Calamba', 'username' => 'cashier_calamba', 'role_id' => 2, 'branch_id' => '3,9', 'company_id' => '2,3'),

            13 => array('name' => 'Head Redemption West Local', 'username' => 'headredemption_westlocal', 'role_id' => 3, 'branch_id' => 1, 'company_id' => 3),
            14 => array('name' => 'Head Redemption West Premier', 'username' => 'headredemption_westpremier', 'role_id' => 3, 'branch_id' => 7, 'company_id' => 2),
            15 => array('name' => 'Head Redemption West ', 'username' => 'headredemption_west', 'role_id' => 3, 'branch_id' => '1,7', 'company_id' => '2,3'),
            16 => array('name' => 'Head Redemption Calamba Local', 'username' => 'headredemption_calambalocal', 'role_id' => 3, 'branch_id' => 3, 'company_id' => 3),
            17 => array('name' => 'Head Redemption Calamba Premier', 'username' => 'headredemption_calambapremier', 'role_id' => 3, 'branch_id' => 9, 'company_id' => 2),
            18 => array('name' => 'Head Redemption Calamba', 'username' => 'headredemption_calamba', 'role_id' => 3, 'branch_id' => '3,9', 'company_id' => '2,3'),

            19 => array('name' => 'Head Cashier West Local', 'username' => 'headcashier_westlocal', 'role_id' => 4, 'branch_id' => 1, 'company_id' => 3),
            20 => array('name' => 'Head Cashier West Premier', 'username' => 'headcashier_westpremier', 'role_id' => 4, 'branch_id' => 7, 'company_id' => 2),
            21 => array('name' => 'Head Cashier West', 'username' => 'headcashier_west', 'role_id' => 4, 'branch_id' => '1,7', 'company_id' => '2,3'),
            22 => array('name' => 'Head Cashier Calamba Local', 'username' => 'headcashier_calambalocal', 'role_id' => 4, 'branch_id' => 3, 'company_id' => 3),
            23 => array('name' => 'Head Cashier Calamba Premier', 'username' => 'headcashier_calambapremier', 'role_id' => 4, 'branch_id' => 9, 'company_id' => 2),
            24 => array('name' => 'Head Cashier Calamba', 'username' => 'headcashier_calamba', 'role_id' => 4, 'branch_id' => '3,9', 'company_id' => '2,3'),

            25 => array('name' => 'Officer In Charge West Local', 'username' => 'oic_westlocal', 'role_id' => 5, 'branch_id' => 1, 'company_id' => 3),
            26 => array('name' => 'Officer In Charge West Premier', 'username' => 'oic_westpremier', 'role_id' => 5, 'branch_id' => 7, 'company_id' => 2),
            27 => array('name' => 'Officer In Charge West', 'username' => 'oic_west', 'role_id' => 5, 'branch_id' => '1,7', 'company_id' => '2,3'),
            28 => array('name' => 'Officer In Charge Calamba Local', 'username' => 'oic_calambalocal', 'role_id' => 5, 'branch_id' => 3, 'company_id' => 3),
            29 => array('name' => 'Officer In Charge Calamba Premier', 'username' => 'oic_calambapremier', 'role_id' => 5, 'branch_id' => 9, 'company_id' => 2),
            30 => array('name' => 'Officer In Charge Calamba', 'username' => 'oic_calamba', 'role_id' => 5, 'branch_id' => '3,9', 'company_id' => '2,3'),

            31 => array('name' => 'Branch Manager West Local', 'username' => 'branchmanager_westlocal', 'role_id' => 6, 'branch_id' => 1, 'company_id' => 3),   
            32 => array('name' => 'Branch Manager West Premier', 'username' => 'branchmanager_westpremier', 'role_id' => 6, 'branch_id' => 7, 'company_id' => 2),
            33 => array('name' => 'Branch Manager West', 'username' => 'branchmanager_west', 'role_id' => 6, 'branch_id' => '1,7', 'company_id' => '2,3'),
            34 => array('name' => 'Branch Manager Calamba Local', 'username' => 'branchmanager_calambalocal', 'role_id' => 6, 'branch_id' => 3, 'company_id' => 3),   
            35 => array('name' => 'Branch Manager Calamba Premier', 'username' => 'branchmanager_calambapremier', 'role_id' => 6, 'branch_id' => 9, 'company_id' => 2),
            36 => array('name' => 'Branch Manager Calamba', 'username' => 'branchmanager_calamba', 'role_id' => 6, 'branch_id' => '3,9', 'company_id' => '2,3'),

            37 => array('name' => 'Viewer', 'username' => 'viewer', 'role_id' => 7, 'branch_id' => NULL, 'company_id' => NULL),
            38 => array('name' => 'Viewer Local', 'username' => 'viewerlocal', 'role_id' => 7, 'branch_id' => 1, 'company_id' => 3),
            39 => array('name' => 'Viewer Premier', 'username' => 'viewerpremier', 'role_id' => 7, 'branch_id' => 7, 'company_id' => 2),
            40 => array('name' => 'Accounting', 'username' => 'accounting', 'role_id' => 8, 'branch_id' => NULL, 'company_id' => NULL),
            41 => array('name' => 'Treasury', 'username' => 'treasury', 'role_id' => 9, 'branch_id' => NULL, 'company_id' => NULL),
            42 => array('name' => 'Manager Local', 'username' => 'managerlocal', 'role_id' => 10, 'branch_id' => 1, 'company_id' => 3),
            43 => array('name' => 'Manager Premier', 'username' => 'managerpremier', 'role_id' => 10, 'branch_id' => 7, 'company_id' => 2),
            44 => array('name' => 'Manager Ecomm', 'username' => 'managerecomm', 'role_id' => 10, 'branch_id' => NULL, 'company_id' => NULL),
            45 => array('name' => 'Administrator', 'username' => 'administrator', 'role_id' => 11, 'branch_id' => NULL, 'company_id' => NULL),
            46 => array('name' => 'Superadmin', 'username' => 'superadmin', 'role_id' => 12, 'branch_id' => NULL, 'company_id' => NULL),

            47 => array('name' => 'Aris Flores', 'username' => 'aris', 'role_id' => 12, 'branch_id' => NULL, 'company_id' => NULL),
            48 => array('name' => 'Test User', 'username' => 'test', 'role_id' => 12, 'branch_id' => NULL, 'company_id' => NULL),
        ];

        foreach($users as $key => $user) {
            $user = User::create([
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

            // create user permission
            UserPermission::create([
                'user_id' => $user->id,
                'uuid' => $user->uuid,
                'user_permission' => !in_array($user->role_id, [11,12]) ? $this->permissions(0) : $this->permissions(1),
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'created_by' => $user->created_by,
                'updated_by' => $user->updated_by
            ]);
        }
    }

    // $key = id of Permission Module;  1 = index, 2 = create (save), 3 = show (view), 4 = edit (update)
    public function permissions($int) {
        $modules = PermissionModule::whereDeleted(false)->get();
        $permissions = [];
        foreach ($modules as $key => $module) {
            $permissions[$key + 1] = (strtolower($module->type) == 'module') ? array_fill(1, 4, $int) : [1 => $int];
        }
        return json_encode($permissions);
    }
}
