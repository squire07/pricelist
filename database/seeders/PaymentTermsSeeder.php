<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\PaymentTerms;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentTermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            '0',
            '7',
            '10',
            '15'
        ];

        foreach($payments as $key => $name) {
            PaymentTerms::create([
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
