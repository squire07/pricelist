<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // company names 
        $companies = [
            1 => array('name' => 'Unlimited Network of Opportunities Int\'l Corp', 'code' => 'LO'),
            2 => array('name' => 'Uno Premier Philippines International Corporation', 'code' => 'PR'), 
            3 => array('name' => 'Onelifestyle', 'code' => 'OL'),
        ];

        foreach($companies as $key => $company) {
            Company::create([
                'uuid' => Str::uuid(),
                'name' => $company['name'],
                'code' => $company['code'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
