<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\CustomerCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Public Market: Booking',
            'Public Market: Extract',
            'Super Market',
            'Side Street',
            'Online',
            'Hotel & Restaurants',
            'Catering Services',
            'Walk-In',
            'Sub Distributor'
        ];

        foreach($categories as $key => $name) {
            CustomerCategories::create([
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
