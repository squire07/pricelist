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
            1 => array('name' => 'West Insula Local', 'code' => 'WES'),
            2 => array('name' => 'Cebu Local', 'code' => 'CEB'),
            3 => array('name' => 'Calamba Local', 'code' => 'CAL'),
            4 => array('name' => 'Baguio Local', 'code' => 'BAG'),
            5 => array('name' => 'Gensan Local', 'code' => 'GEN'),
            6 => array('name' => 'E-Commerce Local', 'code' => 'ECO'),
            7 => array('name' => 'West Insula Premier', 'code' => 'WES'),
            8 => array('name' => 'Cebu Premier', 'code' => 'CEB'),
            9 => array('name' => 'Calamba Premier', 'code' => 'CAL'),   
            10 => array('name' => 'Baguio Premier', 'code' => 'BAG'),
            11 => array('name' => 'Gensan Premier', 'code' => 'GEN'),
            12 => array('name' => 'E-Commerce Premier', 'code' => 'ECO'),
        ];

        foreach($branches as $key => $branch) {
            Branch::create([
                'uuid' => Str::uuid(),
                'name' => $branch['name'],
                'code' => $branch['code'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
