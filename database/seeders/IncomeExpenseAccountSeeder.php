<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncomeExpenseAccount;

class IncomeExpenseAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // company names 
        $accounts = [
            1 => array('transaction_type_id' => 1, 'income_account' => '4010271 - Sales - SRP PHP - LOCAL', 'expense_account' => '5010208 - COGS-SRP - UNO'),
            // 2 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 3 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 4 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 5 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 6 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 7 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 8 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 9 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 10 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 11 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 12 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 13 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 14 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 15 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 16 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 17 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 18 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 19 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 20 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 21 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 22 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 23 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 24 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 25 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 26 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 27 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 28 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 29 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 30 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 31 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 32 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 33 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 34 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 35 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 36 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 37 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 38 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 39 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 40 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 41 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 42 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 43 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 44 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 45 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 46 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 47 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 48 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 49 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 50 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),

            // 51 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 52 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 53 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 54 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 55 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 56 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 57 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 58 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 59 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
            // 60 => array('transaction_type_id' => 1, 'income_account' => '', 'expense_account' => ''),
        ];

        foreach($accounts as $key => $account) {
            IncomeExpenseAccount::create([
                'uuid' => Str::uuid(),
                'name' => $account['name'],
                'code' => $account['code'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
