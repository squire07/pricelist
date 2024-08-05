<?php

namespace Database\Seeders;

use App\Models\AreaGroups;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerAreaGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            'CALAPAN',
            'BACO',
            'SAN TEODORO',
            'PUERTO GALERA',
            'NAUJAN',
            'VICTORIA',
            'SOCORRO',
            'POLA',
            'PINAMALAYAN',
            'GLORIA',
            'BANSUD',
            'BONGABONG',
            'ROXAS',
            'MANSALAY',
            'BULALACAO',
            'OTHERS'
            
        ];

        foreach($groups as $key => $name) {
            AreaGroups::create([
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
