<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncomeExpenseAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class IncomeExpenseAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('income_expense_accounts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sql_file = database_path('data/income_expense_accounts.sql');

        if (File::exists($sql_file)) {
            $sql = File::get($sql_file);
            DB::unprepared($sql);
        }
    }
}
