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
            1 => array('id' => 1, 'name' => 'TDT Powersteel Corporation', 'code' => 'TDT', 'status' => 1),
        ];

        foreach($companies as $key => $company) {
            Company::create([
                'uuid' => Str::uuid(),
                'name' => $company['name'],
                'code' => $company['code'],
                'status' => $company['status'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => Auth::user()->name ?? 'System',
                'updated_by' => Auth::user()->name ?? 'System'
            ]);
        }
    }
}
