<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\TransactionType;
use App\Helpers\Helper;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaction_types = TransactionType::whereDeleted(false)->get();

        foreach($transaction_types as $price_list) {

            $param = '/api/resource/Item Price?filters=[["Item Price","price_list","in", ["' . $price_list->name .'"]]]&fields=["name","item_code","item_name","price_list","currency","price_list_rate","nuc"]&limit=1000';
            $data = Helper::get_erpnext_data($param);

            foreach($data['data'] as $key => $item) {
                Item::create([
                    'uuid' => Str::uuid(),
                    'code' => $item['item_code'],
                    'transaction_type_id' => $price_list->id,
                    'name' => $item['item_name'],
                    'description' => $price_list->name, // no defined item description in erpnext
                    'amount' => isset($item['price_list_rate']) && !empty($item['price_list_rate']) ? $item['price_list_rate'] : 0,
                    'nuc' => isset($item['nuc']) && !empty($item['nuc']) ? $item['nuc'] : 0,
                    'rs_points' => 0, // no defined rs_points in erpnext
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => 'System',
                    'updated_by' => 'System'
                ]);
            }

            // prevent erpnext api limiter by blocking the request
            sleep(5);
        }
    }
}
