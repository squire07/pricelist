<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\TransactionType;
use Carbon\Carbon;
use Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::whereDeleted(false)->get();
        return view('item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }

    // this should be moved at api
    public function sync_item()
    {
        set_time_limit(600);

        // get all the transaction type
        $transaction_types = TransactionType::whereDeleted(false)->get();

        // to refactor soon
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // to prevent maximum execution time error, dump all data to an object
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
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name
                ]);
            }
            sleep(5);
        }
        return true;
    }
}
