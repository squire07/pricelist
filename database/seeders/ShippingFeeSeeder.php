<?php

namespace Database\Seeders;

use App\Models\ShippingFee;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShippingFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shipping_fees = [
            1 => array('parcel_size' => 'PARCEL (S)', 'dimension' => '3600', 'region' => 'NCR', 'parcel_rate' => '147.00'),
            2 => array('parcel_size' => 'PARCEL (S)', 'dimension' => '3600', 'region' => 'Luzon', 'parcel_rate' => '172.00'),
            3 => array('parcel_size' => 'PARCEL (S)', 'dimension' => '3600', 'region' => 'Visayas', 'parcel_rate' => '188.00'),
            4 => array('parcel_size' => 'PARCEL (S)', 'dimension' => '3600', 'region' => 'Mindanao', 'parcel_rate' => '188.00'),
            5 => array('parcel_size' => 'PARCEL (L)', 'dimension' => '6100', 'region' => 'NCR', 'parcel_rate' => '216.00'),
            6 => array('parcel_size' => 'PARCEL (L)', 'dimension' => '6100', 'region' => 'Luzon', 'parcel_rate' => '278.00'),
            7 => array('parcel_size' => 'PARCEL (L)', 'dimension' => '6100', 'region' => 'Visayas', 'parcel_rate' => '290.00'),
            8 => array('parcel_size' => 'PARCEL (L)', 'dimension' => '6100', 'region' => 'Mindanao', 'parcel_rate' => '290.00'),

        ];

        foreach($shipping_fees as $key => $shipping_fee) {
            ShippingFee::create([
                'uuid' => Str::uuid(),
                'parcel_size' => $shipping_fee['parcel_size'],
                'dimension' => $shipping_fee['dimension'],
                'region' => $shipping_fee['region'],
                'parcel_rate' => $shipping_fee['parcel_rate'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
