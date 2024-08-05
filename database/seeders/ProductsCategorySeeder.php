<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\ProductsCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // STATIC: 
        $product_categories = [
            1 => array('id' => 1, 'code' => 'HTDG', 'name' => 'HOTDOGS'),
            2 => array('id' => 2, 'code' => 'NTVE', 'name' => 'NATIVE DELICACIES'),
            3 => array('id' => 3, 'code' => 'HAMM', 'name' => 'HAM'),
            4 => array('id' => 4, 'code' => 'BCON', 'name' => 'BACON'),
            5 => array('id' => 5, 'code' => 'SAUG', 'name' => 'SAUSAGE'),
            6 => array('id' => 6, 'code' => 'CLDC', 'name' => 'COLD CUTS'),
            7 => array('id' => 7, 'code' => 'SEAF', 'name' => 'SEAFOOD'),
            8 => array('id' => 8, 'code' => 'CHKN', 'name' => 'CHICKEN'),
            9 => array('id' => 9, 'code' => 'PORK', 'name' => 'PORK'),
            10 => array('id' => 10, 'code' => 'BEEF', 'name' => 'BEEF'),
            11 => array('id' => 11, 'code' => 'SMAI', 'name' => 'SIOMAI'),
            12 => array('id' => 12, 'code' => 'FRIS', 'name' => 'FRIES'),
            13 => array('id' => 13, 'code' => 'VGTB', 'name' => 'VEGETABLE'),
            14 => array('id' => 14, 'code' => 'LPIA', 'name' => 'LUMPIA'),
        ];

        foreach($product_categories as $key => $product_category) {
            ProductsCategory::create([
                'uuid' => Str::uuid(),
                'code' => $product_category['code'],
                'name' => $product_category['name'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => Auth::user()->name ?? 'System',
                'updated_by' => Auth::user()->name ?? 'System'
            ]);
        }
    }
}
