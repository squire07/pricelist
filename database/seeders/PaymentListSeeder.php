<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\PaymentList;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_lists = [
            1 => array('name' => 'GCashUNOEcomm', 'code' => '003'),
            2 => array('name' => 'BDO', 'code' => '3920049009'),
            3 => array('name' => 'EastwestBank', 'code' => '200007016076'),
            4 => array('name' => 'GCashUNOBaguio', 'code' => '008'),
            5 => array('name' => 'GCashUNOCalamba', 'code' => '007'),
            6 => array('name' => 'GCashUNOCebu', 'code' => '004'),
            7 => array('name' => 'GCashUNOLocalInsula', 'code' => '001'),
            8 => array('name' => 'GCashUNOGensan', 'code' => '006'),
            9 => array('name' => 'RCBC', 'code' => '1150006089'),
            10 => array('name' => 'Security Bank', 'code' => '3920049009'),
            11 => array('name' => 'Union Bank', 'code' => '200007016076'),
            12 => array('name' => 'Union Bank', 'code' => '008'),
            13 => array('name' => 'Union Bank of the Philippines', 'code' => '007'),
            14 => array('name' => 'BDO', 'code' => '004'),
            15 => array('name' => 'Union Bank', 'code' => '100590246608'),
            16 => array('name' => 'GCashUNOGensan', 'code' => '006'),
        ];

        foreach($payment_lists as $key => $payment_list) {
            PaymentList::create([
                'uuid' => Str::uuid(),
                'name' => $payment_list['name'],
                'code' => $payment_list['code'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
