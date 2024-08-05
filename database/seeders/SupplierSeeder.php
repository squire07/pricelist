<?php

namespace Database\Seeders;

use App\Models\Suppliers;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            1 => array('name' => 'KING JAMES FOOD MANUFACTURING INC.', 'proprietor' => 'JAIME LABUGA', 'address' => 'STERLING COMPOUND, CARMONA, CAVITE', 'zip_code' => '3434', 'email' => NULL, 'contact_number' => '09758907868', 'vat_type' => 'VAT', 'tin' => '008-990-632-000', 'remarks' => NULL),

        ];

        foreach($suppliers as $key => $supplier) {
            Suppliers::create([
                'uuid' => Str::uuid(),
                'name' => $supplier['name'],
                'proprietor' => $supplier['proprietor'],
                'address' => $supplier['address'],
                'zip_code' => $supplier['zip_code'],
                'email' => $supplier['email'],
                'contact_number' => $supplier['contact_number'],
                'vat_type' => $supplier['vat_type'],
                'tin' => $supplier['tin'],
                'remarks' => $supplier['remarks'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
