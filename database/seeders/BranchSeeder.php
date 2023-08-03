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
            'West Insula Local',
            'Cebu Local',
            'Calamba Local',
            'Davao Local',
            'Baguio Local',
            'Gensan Local',
            'West Insula Premier',
            'Cebu Premier',
            'Calamba Premier',
            'Davao Premier',
            'Baguio Premier',
            'Gensan Premier',
            'E-Commerce - UNO BILIS'
        ];

        foreach($branches as $key => $name) {
            Branch::create([
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
