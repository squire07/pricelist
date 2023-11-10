<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

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
}
