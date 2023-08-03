<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            1 => array('code' => 'PN1 - 1', 
                        'transaction_type_id' => 1, 
                        'name' => 'Some Product Name 1', 
                        'description' => 'some description goes here', 
                        'amount' => 11.99, 
                        'nuc' => 11,
                        'rs_points' => 11.11),
            2 => array('code' => 'PN1 - 2', 
                        'transaction_type_id' => 1, 
                        'name' => 'Some Product Name 2', 
                        'description' => 'some description goes here', 
                        'amount' => 22.99, 
                        'nuc' => 21,
                        'rs_points' => 11.22),
            3 => array('code' => 'PN1 - 3', 
                        'transaction_type_id' => 1, 
                        'name' => 'Some Product Name 3', 
                        'description' => 'some description goes here', 
                        'amount' => 33.99, 
                        'nuc' => 31,
                        'rs_points' => 11.33),
            4 => array('code' => 'PN2 - 1', 
                        'transaction_type_id' => 2, 
                        'name' => 'Product 2 - 1', 
                        'description' => 'some description goes here', 
                        'amount' => 199.99, 
                        'nuc' => 7,
                        'rs_points' => 22.11),
            5 => array('code' => 'PN2 - 2', 
                        'transaction_type_id' => 2, 
                        'name' => 'Product 2 - 2', 
                        'description' => 'some description goes here', 
                        'amount' => 299.99, 
                        'nuc' => 5,
                        'rs_points' => 22.22),
        ];

        foreach($items as $key => $item) {
            Item::create([
                'uuid' => Str::uuid(),
                'code' => $item['code'],
                'transaction_type_id' => $item['transaction_type_id'],
                'name' => $item['name'],
                'description' => $item['description'],
                'amount' => $item['amount'],
                'nuc' => $item['nuc'],
                'rs_points' => $item['rs_points'],
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
                'created_by' => 'System',
                'updated_by' => 'System'
            ]);
        }
    }
}
