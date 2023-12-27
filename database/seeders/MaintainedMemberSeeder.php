<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\MaintainedMember;

class MaintainedMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MaintainedMember::truncate();
  
        $csvFile = fopen(base_path('database/data/maintained_members.csv'), 'r');
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000000, ',')) !== FALSE) {
            if (!$firstline) {
                MaintainedMember::create([
                    'uuid' => Str::uuid(),
                    'data_id' => $data['0'],
                    'bcid' => $data['1'],
                    'year' => $data['2'],
                    'month' => $data['3'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => 'System',
                    'updated_by' => 'System'
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
