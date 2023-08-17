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
        $payment_list = [
            'Cash',
            'Credit Card',
            'E-Banks',
            'Gift Certificate',
            'E-Store Commission'
        ];

        foreach($payment_list as $key => $name) {
            PaymentList::create([
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
