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
                'code' => 'WES', 'company_id' => 3, 
                'cost_center' => '001',
                'cost_center_name' => '001 - MAIN-WEST INSULA - UNO - LOCAL',
                'warehouse' => 'West Insula Merchandise - LOCAL'
            ),
            2 => array(
                'name' => 'Cebu Local', 
                'code' => 'CEB', 'company_id' => 3, 
                'cost_center' => '002',
                'cost_center_name' => '002 - CEBU - LOCAL',
                'warehouse' => 'Cebu Merchandise - LOCAL'
            ),
            3 => array(
                'name' => 'Calamba Local', 
                'code' => 'CAL', 'company_id' => 3, 
                'cost_center' => '006',
                'cost_center_name' => '006 - CALAMBA - LOCAL',
                'warehouse' => 'Calamba Merchandise - LOCAL'
            ),
            4 => array(
                'name' => 'Baguio Local', 
                'code' => 'BAG', 'company_id' => 3, 
                'cost_center' => '005',
                'cost_center_name' => '005 - BAGUIO - LOCAL',
                'warehouse' => 'Baguio Merchandise - LOCAL'
            ),
            5 => array(
                'name' => 'Gensan Local', 
                'code' => 'GEN', 'company_id' => 3, 
                'cost_center' => '004',
                'cost_center_name' => '004 - GENSAN - LOCAL',
                'warehouse' => 'General Santos City Merchandise - LOCAL'
            ),
            6 => array(
                'name' => 'E-Commerce Local', 
                'code' => 'ECO', 'company_id' => 3, 
                'cost_center' => '008',
                'cost_center_name' => '008 - E-COMMERCE - LOCAL',
                'warehouse' => 'E-Commerce Merchandise - LOCAL'
            ),
            7 => array(
                'name' => 'West Insula Premier', 
                'code' => 'WES', 'company_id' => 2, 
                'cost_center' => '001',
                'cost_center_name' => '001 - MAIN-WEST INSULA - PREMIER',
                'warehouse' => 'West Premier Merchandise - PREMIER'
            ),
            8 => array(
                'name' => 'Cebu Premier', 
                'code' => 'CEB', 'company_id' => 2, 
                'cost_center' => '002',
                'cost_center_name' => '002 - CEBU - PREMIER',
                'warehouse' => 'Cebu Merchandise - PREMIER'
            ),
            9 => array(
                'name' => 'Calamba Premier', 
                'code' => 'CAL', 'company_id' => 2, 
                'cost_center' => '006',
                'cost_center_name' => '006 - CALAMBA - PREMIER',
                'warehouse' => 'Calamba Merchandise - PREMIER'
            ),   
            10 => array(
                'name' => 'Baguio Premier', 
                'code' => 'BAG', 'company_id' => 2, 
                'cost_center' => '005',
                'cost_center_name' => '005 - BAGUIO - PREMIER',
                'warehouse' => 'Baguio Merchandise - PREMIER'
            ),
            11 => array(
                'name' => 'Gensan Premier', 
                'code' => 'GEN', 'company_id' => 2, 
                'cost_center' => '004',
                'cost_center_name' => '004 - GENSAN - PREMIER',
                'warehouse' => 'General Santos Merchandise - PREMIER'
            ),
            12 => array(
                'name' => 'E-Commerce Premier', 
                'code' => 'ECO', 'company_id' => 2, 
                'cost_center' => '008',
                'cost_center_name' => '008 - E-COMMERCE - PREMIER',
                'warehouse' => 'E-Commerce Merchandise - PREMIER'
            ),
            13 => array(
                'name' => 'UBC HONG KONG', 
                'code' => 'UHK', 'company_id' => 2, 
                'cost_center' => '041',
                'cost_center_name' => '041 - HONGKONG - PREMIER',
                'warehouse' => 'Hongkong UBC Merchandise - PREMIER'
            ),
            14 => array(
                'name' => 'Uno Café', 
                'code' => 'CAF', 'company_id' => 2, 
                'cost_center' => '015',
                'cost_center_name' => '015 - CAFE-WEST INSULA - PREMIER',
                'warehouse' => 'Uno Café Merchandise - PREMIER'
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
                'warehouse' => $branch['warehouse'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
