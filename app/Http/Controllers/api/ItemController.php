<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Item;
use App\Models\ItemBundle;
use Carbon\Carbon;
use App\Helpers\Helper;
class ItemController extends Controller
{
    /**
     * Returns JSON object.
     */
    public function get_item_by_transaction_type($id)
    {
        return Item::whereDeleted(false)->whereTransactionTypeId($id)->orderBy('name')->get();
    }

    /**
     * Returns JSON object.
     */
    public function get_item_by_id($id)
    {
        return Item::whereDeleted(false)->whereId($id)->get();
    }

    /**
     * Returns JSON object.
     */
    public function get_stock_by_warehouse($item_id, $branch_id)
    {
        $current_date = Carbon::now()->format('Y-m-d');

        // $branch_id is used to get the warehouse name
        $branch = Branch::whereId($branch_id)->first();
        $warehouse = $branch->warehouse;
        $item = Item::whereDeleted(false)->whereId($item_id)->orderBy('name')->first();

        $item_param = '/api/resource/Stock Ledger Entry?filters=[["item_code", "=", "' . $item->code . '"], ["posting_date", "<=", "' . $current_date . '"], ["warehouse", "in", ["' . $warehouse . '"]]]&fields=["item_code", "warehouse", "sum(actual_qty) as total_qty"]'; 
        $item_data = Helper::get_erpnext_data($item_param);
        $data = json_decode($item_data->getBody()->getContents(), true);

        $total_quantity = isset($data['data'][0]['total_qty']) ? $data['data'][0]['total_qty'] : 0;

        // Convert the array to JSON and return
        return response()->json(['total_quantity' => $total_quantity]);
    }

    /**
     * Returns JSON object.
     */
    public function for_future_use($item_id, $branch_id)
    {
        $current_date = Carbon::now()->format('Y-m-d');

        // $branch_id is used to get the warehouse name
        $branch = Branch::whereId($branch_id)->first();
        $warehouse = $branch->warehouse;

        $items = Item::whereDeleted(false)->whereId($item_id)->orderBy('name')->get();
        
        foreach($items as $key => $item) {
            $item_param = '/api/resource/Stock Ledger Entry?filters=[["item_code", "=", "' . $item->code . '"], ["posting_date", "<=", "' . $current_date . '"], ["warehouse", "in", ["' . $warehouse . '"]]]&fields=["item_code", "warehouse", "sum(actual_qty) as total_qty"]'; 

            $item_data = Helper::get_erpnext_data($item_param);

            $data = json_decode($item_data->getBody()->getContents(), true);

            $item['item_quantity'] = $data['data'][0]['total_qty'];
        }

        return $items;
    }

    public function get_item_bundle($bundle_code)
    {
        return ItemBundle::whereDeleted(0)->whereBundleName($bundle_code)->orderBy('item_description')->get();
    }
}
