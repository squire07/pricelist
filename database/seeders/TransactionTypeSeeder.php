<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransactionType;
use App\Helpers\Helper;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ERPNext 
        $param = '/api/resource/Price List?limit=500&filters=[["selling","=","1"]]';
        $data = Helper::get_erpnext_data($param);

        foreach($data['data']['data'] as $key => $price_lists){
            TransactionType::create([
                'uuid' => Str::uuid(),
                'name' => $price_lists['name'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
