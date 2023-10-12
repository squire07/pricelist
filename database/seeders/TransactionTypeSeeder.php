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
        // $transaction_types = [
        //     'Standard Selling',
        //     'Distributor Price',
        //     'Unopreneur\'s Selling',
        //     'UBC\'s Selling',
        //     'UBC Price',
        //     'UPC Price',
        //     'Unoshop SRP Price',
        //     'Shopee SRP Price',
        //     'LazMall SRP Price',
        //     'EStore SRP Price',
        //     'EStore Distributor Price',
        //     'Credit Card Distributor',
        //     'Credit Card UPC Price',
        //     'UNO Bilis Serbisyo Distributor Price',
        //     'UNO Bilis Serbisyo UPC Price',
        //     'Onelifestyle Distributor Price',
        //     'Onelifestyle UPC Price',
        //     'Buy 1 Take 1 Promo',
        //     'Promo Free Regular Package',
        //     'Promo Free Regular RS',
        //     'Promo Free New UPC',
        //     'Promo Free New RS',
        //     'Promo Free Sign UBC Package',
        //     'Promo Free Sign UBC RS',
        // ];

        // ERPNext 
        $param = '/api/resource/Price List?limit=500&filters=[["selling","=","1"]]';
        $data = Helper::get_erpnext_data($param);

        foreach($data['data'] as $key => $price_lists){
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
