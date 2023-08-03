<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;

class DistributorController extends Controller
{
    /**
     * Returns JSON object.
     */
    public function get_distributor_by_id($bcid)
    {
        return Distributor::whereDeleted(false)->whereBcid($bcid)->get();
    }
}
