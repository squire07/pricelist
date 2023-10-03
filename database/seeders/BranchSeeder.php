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
            1 => array('name' => 'West Insula Local', 'code' => 'WES', 'company_id' => 1),
            2 => array('name' => 'Cebu Local', 'code' => 'CEB', 'company_id' => 1),
            3 => array('name' => 'Calamba Local', 'code' => 'CAL', 'company_id' => 1),
            4 => array('name' => 'Baguio Local', 'code' => 'BAG', 'company_id' => 1),
            5 => array('name' => 'Gensan Local', 'code' => 'GEN', 'company_id' => 1),
            6 => array('name' => 'E-Commerce Local', 'code' => 'ECO', 'company_id' => 1),
            7 => array('name' => 'West Insula Premier', 'code' => 'WES', 'company_id' => 2),
            8 => array('name' => 'Cebu Premier', 'code' => 'CEB', 'company_id' => 2),
            9 => array('name' => 'Calamba Premier', 'code' => 'CAL', 'company_id' => 2),   
            10 => array('name' => 'Baguio Premier', 'code' => 'BAG', 'company_id' => 2),
            11 => array('name' => 'Gensan Premier', 'code' => 'GEN', 'company_id' => 2),
            12 => array('name' => 'E-Commerce Premier', 'code' => 'ECO', 'company_id' => 2),
        ];

        foreach($branches as $key => $branch) {
            Branch::create([
                'uuid' => Str::uuid(),
                'name' => $branch['name'],
                'code' => $branch['code'],
                'company_id' => $branch['company_id'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
