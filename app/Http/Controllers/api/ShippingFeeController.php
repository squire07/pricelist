<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingFee;

class ShippingFeeController extends Controller
{
    /**
     * Returns JSON object.
     */
    public function get_shippingfee_by_id($id)
    {
        return ShippingFee::whereDeleted(false)->whereId($id)->get();
    }

}
