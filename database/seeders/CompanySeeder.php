<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Helpers\Helper;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // company names 
        $company_codes = [
            1 => array('id' => 1, 'code' => 'HW'),
            2 => array('id' => 2, 'code' => 'PR'), 
            3 => array('id' => 3, 'code' => 'LO'),
        ];

        $param = '/api/resource/Company';
        $data = Helper::get_erpnext_data($param);

        foreach($data['data'] as $key => $company) {
            Company::create([
                'uuid' => Str::uuid(),
                'name' => $company['name'],
                'code' => $company_codes[$key+1]['code'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
