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
                'name' => 'Head Office', 
                'code' => 'HOF'
            ),
            2 => array(
                'name' => 'Bulacan', 
                'code' => 'BUL'
            ),
            3 => array(
                'name' => 'Cebu', 
                'code' => 'CEB'
            ),
            4 => array(
                'name' => 'Davao', 
                'code' => 'DAV'
            ),
            5 => array(
                'name' => 'Iloilo', 
                'code' => 'ILO'
            ),
            6 => array(
                'name' => 'Cagayan de Oro', 
                'code' => 'CDO'
            ),
            7 => array(
                'name' => 'Isabela', 
                'code' => 'ISA'
            ),
            8 => array(
                'name' => 'Cavite', 
                'code' => 'CAV'
            ),
            9 => array(
                'name' => 'Batangas', 
                'code' => 'BAT'
            ),
            10 => array(
                'name' => 'Palawan', 
                'code' => 'PAL'
            ),
            11 => array(
                'name' => 'Legazpi', 
                'code' => 'LEG'
            ),
            12 => array(
                'name' => 'General Santos', 
                'code' => 'GEN'
            ),
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
