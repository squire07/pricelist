<?php

namespace App\Helpers;

use Carbon\Carbon;
use Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Models\Sales;
use App\Models\History;

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
        $last = isset($sales->so_no) ? substr($sales->so_no, strlen($sales->so_no)-4) : 0;
        // remove leading zeros, then increment by 1
        $last_number = $last == 0 ? 1 : ltrim($last, 0) + 1;

        $check = isset($sales->so_no) && strpos($sales->so_no, Carbon::now()->format('Ymd')); // get current date in yyyymmdd format and compare with the last so_no
        if($check) { // true? increment by 1
            return 'SO-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 4) . $last_number, - 4);
        } else { // false? start at 1 again with new date
            return 'SO-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 4) . '1', - 4);
        }
    }

    public static function badge($status_id)
    {
        switch($status_id) {
            case 1: 
                return 'bg-info';
            case 2: 
                return 'bg-warning';
            case 3: 
                return 'bg-danger';
            case 4: 
                return 'bg-success';
            case 5: 
                return 'bg-primary';
            case 6: 
                return 'bg-success';
            case 7: 
                return 'bg-danger';
            case 8: 
                return 'bg-success';
            case 9: 
                return 'bg-danger';
            default: 
                return 'bg-primary';
        }
    }

    public static function history($record_id, $record_uuid, $transaction_type_id, $status_id, $so_no, $module, $event_name, $remarks) {
        $history = new History();
        $history->record_id = $record_id;
        $history->uuid = $record_uuid;
        $history->transaction_type_id = $transaction_type_id;
        $history->status_id = $status_id;
        $history->so_no = $so_no;
        $history->module = $module;
        $history->event_name = $event_name;
        $history->remarks = $remarks;
        $history->created_by = Auth::user()->name;
        $history->updated_by = Auth::user()->name;
        $history->created_at = Carbon::now();
        $history->updated_at = Carbon::now();
        $history->save();

        return true;
    }
}