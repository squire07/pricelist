<?php

namespace App\Helpers;

use Carbon\Carbon;
use Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Models\Sales;

class Helper {

    // create uuid - non repeating
    public static function uuid($model) 
    {
        $uniqueCode = false;
        $newUuid = '';
        while($uniqueCode == false){
            $newUuid = Str::uuid();
            $uniqueCode = $model::whereUuid($newUuid)->exists() ? false : true;
        }
        return $newUuid;
    }

    // format: SO-20230804-001
    public static function generate_so_no()
    {
        $sales = Sales::latest()->first();

        // get the last 4 character of so number
        $last = substr($sales->so_no, strlen($sales->so_no)-4);
        // remove leading zeros, then increment by 1
        $last_number = ltrim($last, 0) + 1;

        $check = strpos($sales->so_no, Carbon::now()->format('Ymd')); // get current date in yyyymmdd format and compare with the last so_no
        if($check) { // true? increment by 1
            return 'SO-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 4) . $last_number, - 4);
        } else { // false? start at 1 again with new date
            return 'SO-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 4) . '1', - 4);
        }
    }

}