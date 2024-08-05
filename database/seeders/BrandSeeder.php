<?php

namespace Database\Seeders;

use App\Models\Brands;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // STATIC: 
        $brands = [
            1 => array('id' => 1, 'code' => 'KING', 'name' => 'KING JAMES'),
            2 => array('id' => 2, 'code' => 'MNGL', 'name' => 'MONGOLIAN'),
            3 => array('id' => 3, 'code' => 'MSTR', 'name' => 'MAESTRO'),
            4 => array('id' => 4, 'code' => 'PNYF', 'name' => 'PINOY FIESTA'),
            5 => array('id' => 5, 'code' => 'SEAF', 'name' => 'SEAFOOD'),
            6 => array('id' => 6, 'code' => 'MDBL', 'name' => 'MYDIBEL'),
            7 => array('id' => 7, 'code' => 'PKMT', 'name' => 'PORK'),
            8 => array('id' => 8, 'code' => 'BFMT', 'name' => 'BEEF'),
            9 => array('id' => 9, 'code' => 'CKNM', 'name' => 'CHICKEN'),
            10 => array('id' => 10, 'code' => 'PSBR', 'name' => 'S-BRAND'),
        ];

        foreach($brands as $key => $brand) {
            Brands::create([
                'uuid' => Str::uuid(),
                'code' => $brand['code'],
                'name' => $brand['name'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => Auth::user()->name ?? 'System',
                'updated_by' => Auth::user()->name ?? 'System'
            ]);
        }
    }
}
