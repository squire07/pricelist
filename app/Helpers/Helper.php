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
        $id = $sales->id + 1 ?? 1; // if no existing record, start at 1
        return 'SO-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 3).$id, - 3);
    }

}