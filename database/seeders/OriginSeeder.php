<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Origin;
use Carbon\Carbon;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $origins = [
            'Distributor Shop',
            'Shelfspace',
            'Local Package Store',
            'Premier Package Store',
            'MyStore',
        ];

        foreach($origins as $key => $origin) {
            Origin::create([
                'uuid' => Str::uuid(),
                'name' => $origin,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
