<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Distributor;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $distributors = [
        //     'IT Dummy',
        // ];

        // foreach($distributors as $key => $distributor) {
        //     DB::table('distributors')->insert(
        //         array(
        //             'distributor' => $distributor,
        //             'created_at' => Carbon::now()->toDateTimeString(),
        //             'updated_at' => Carbon::now()->toDateTimeString()
        //         ),
        //     );
        // }

        Distributor::truncate();
  
        $csvFile = fopen(base_path('database/data/list_of_distributor.csv'), 'r');
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000000, ',')) !== FALSE) {
            if (!$firstline) {
                Distributor::create([
                    'bcid' => $data['0'],
                    'distributor' => $data['1'],
                    'group' => $data['2'],
                    'subgroup' => $data['3'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => 'System',
                    'updated_by' => 'System'
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);

        // the CSV file contains literal string 'NULL' which must be converted into definite NULL value; 
        Distributor::where('group', 'NULL')->update(['group' => NULL, 'subgroup' => NULL]);
    }

}
