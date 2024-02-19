<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Models\MaintainedMember;
use Carbon\Carbon;

class DistributorController extends Controller
{
    /**
     * Returns JSON object.
     */
    public function get_distributor_by_id($bcid)
    {
        return Distributor::whereDeleted(false)->whereBcid($bcid)->get();
    }

    public function get_maintained_distributor_by_id($bcid)
    {
        $month = Carbon::now()->format('n');
        $year = Carbon::now()->year;

        $maintained = MaintainedMember::whereDeleted(false)
                    ->where('bcid', $bcid)
                    ->where('year', $year)
                    ->where('month', $month)
                    ->first();

        // get the member details
        if($maintained) {
            return Distributor::whereDeleted(false)->whereBcid($bcid)->get();
        } else {
            return [];
        }
    }
}
