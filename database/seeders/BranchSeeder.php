<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            1 => array(
                'name' => 'West Insula Local', 
                'code' => 'WES', 'company_id' => 1, 
                'cost_center' => '001',
                'cost_center_name' => '001 - MAIN-WEST INSULA - UNO - LOCAL'
            ),
            2 => array(
                'name' => 'Cebu Local', 
                'code' => 'CEB', 'company_id' => 1, 
                'cost_center' => '002',
                'cost_center_name' => '002 - CEBU - LOCAL'
            ),
            3 => array(
                'name' => 'Calamba Local', 
                'code' => 'CAL', 'company_id' => 1, 
                'cost_center' => '006',
                'cost_center_name' => '006 - CALAMBA - LOCAL'
            ),
            4 => array(
                'name' => 'Baguio Local', 
                'code' => 'BAG', 'company_id' => 1, 
                'cost_center' => '005',
                'cost_center_name' => '005 - BAGUIO - LOCAL'
            ),
            5 => array(
                'name' => 'Gensan Local', 
                'code' => 'GEN', 'company_id' => 1, 
                'cost_center' => '004',
                'cost_center_name' => '004 - GENSAN - LOCAL'
            ),
            6 => array(
                'name' => 'E-Commerce Local', 
                'code' => 'ECO', 'company_id' => 1, 
                'cost_center' => '008',
                'cost_center_name' => '008 - E-COMMERCE - LOCAL'
            ),
            7 => array(
                'name' => 'West Insula Premier', 
                'code' => 'WES', 'company_id' => 2, 
                'cost_center' => '001',
                'cost_center_name' => '001 - MAIN-WEST INSULA - PREMIER'
            ),
            8 => array(
                'name' => 'Cebu Premier', 
                'code' => 'CEB', 'company_id' => 2, 
                'cost_center' => '002',
                'cost_center_name' => '002 - CEBU - PREMIER'
            ),
            9 => array(
                'name' => 'Calamba Premier', 
                'code' => 'CAL', 'company_id' => 2, 
                'cost_center' => '006',
                'cost_center_name' => '006 - CALAMBA - PREMIER'
            ),   
            10 => array(
                'name' => 'Baguio Premier', 
                'code' => 'BAG', 'company_id' => 2, 
                'cost_center' => '005',
                'cost_center_name' => '005 - BAGUIO - PREMIER'
            ),
            11 => array(
                'name' => 'Gensan Premier', 
                'code' => 'GEN', 'company_id' => 2, 
                'cost_center' => '004',
                'cost_center_name' => '004 - GENSAN - PREMIER'
            ),
            12 => array(
                'name' => 'E-Commerce Premier', 
                'code' => 'ECO', 'company_id' => 2, 
                'cost_center' => '008',
                'cost_center_name' => '008 - E-COMMERCE - PREMIER'
            ),
        ];

        foreach($branches as $key => $branch) {
            Branch::create([
                'uuid' => Str::uuid(),
                'name' => $branch['name'],
                'code' => $branch['code'],
                'company_id' => $branch['company_id'],
                'cost_center' => $branch['cost_center'],
                'cost_center_name' => $branch['cost_center_name'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
