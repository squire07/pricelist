<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\AgentCategories;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = [
            'Not Applicable',
            'Booking Agent',
            'Extract Agent',
            'Food Service Agent',
        ];

        foreach($agents as $key => $name) {
            AgentCategories::create([
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
