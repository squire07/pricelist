<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            1 => array('id' => 1, 'name' => 'CASH'),
            2 => array('id' => 2, 'name' => 'COD'),
            3 => array('id' => 3, 'name' => 'CHEQUE'),
            4 => array('id' => 4, 'name' => 'DIGITAL WALLET'),
        ];

        foreach($payments as $key => $payment) {
            PaymentMethod::create([
                'uuid' => Str::uuid(),
                'name' => $payment['name'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => Auth::user()->name ?? 'System',
                'updated_by' => Auth::user()->name ?? 'System'
            ]);
        }
    }
}
