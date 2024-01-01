<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Helpers\Helper;
use Auth;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // STATIC: 
        $companies = [
            1 => array('id' => 1, 'name' => 'HOW Holdings Corporation', 'code' => 'HW', 'status_id' => 9),
            2 => array('id' => 2, 'name' => 'Uno Premier Philippines International Corporation', 'code' => 'PR', 'status_id' => 8), 
            3 => array('id' => 3, 'name' => 'Unlimited Network of Opportunities Int\'l Corp', 'code' => 'LO', 'status_id' => 8),
        ];

        foreach($companies as $key => $company) {
            Company::create([
                'uuid' => Str::uuid(),
                'name' => $company['name'],
                'code' => $company['code'],
                'status_id' => $company['status_id'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => Auth::user()->name ?? 'System',
                'updated_by' => Auth::user()->name ?? 'System'
            ]);
        }
    }
}
