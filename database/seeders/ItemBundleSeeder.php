<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\ItemBundle;
use App\Models\TransactionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ItemBundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaction_types = TransactionType::whereDeleted(false)
                                ->whereIn('id', Helper::get_product_assembly_ids())
                                ->whereDeleted(0)
                                ->get();

        foreach($transaction_types as $key => $transaction_type) {

            $items = Item::whereTransactionTypeId($transaction_type->id)
                            ->whereDeleted(0)
                            ->where('amount', '>', 0)
                            ->get();

            foreach($items as $item_key => $item) {         

                $param = '/api/resource/Product Bundle/' . $item->code;

                try {
                    $data = Helper::get_erpnext_data_v2($param);
                    
                    if($data->getStatusCode() == 200) {
                        $data = json_decode($data->getBody()->getContents(), true);
                        foreach($data as $key => $bundles) {
                           
                            foreach($bundles['items'] as $bk => $bundle) {
                                ItemBundle::firstOrCreate([
                                    // 'uuid' => Str::uuid(),
                                    'bundle_name' => $bundles['name'], // with 's'
                                    'bundle_description' => $bundles['description'], // with 's'
                                    'item_code' => $bundle['item_code'],
                                    'item_description' => $bundle['description'],
                                    'quantity' => $bundle['qty'],
                                    'uom' => $bundle['uom'],
                                    'created_by' => 'System',
                                    'updated_by' => 'System'
                                ]);
                            }
                        }
                    } else {
                        continue;
                    }
                } catch (\Exception $e) {
                    continue;
                }
                sleep(2);
            }
        }

        // delete duplicates; issue with ERPNext
        DB::raw('delete ib1 FROM item_bundles ib1 INNER JOIN item_bundles ib2 WHERE ib1.id > ib2.id AND ib1.bundle_name = ib2.bundle_name AND ib1.bundle_description = ib2.bundle_description AND ib1.item_code = ib2.item_code AND ib1.quantity = ib2.quantity AND ib1.uom = ib2.uom');
    }
}
