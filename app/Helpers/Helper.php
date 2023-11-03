<?php

namespace App\Helpers;

use Carbon\Carbon;
use Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Distributor;
use App\Models\History;
use App\Models\PermissionModule;
use App\Models\Sales;
use App\Models\SalesInvoiceAssignmentDetail;
use App\Models\User;
use Auth;
use Session;
use GuzzleHttp\Client;
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
    public static function generate_so_no($branch_id)
    {
        // get branch code by branch id
        $branch_code = Branch::whereId($branch_id)->whereDeleted(false)->first()->code;

        // get company code
        $branch = Branch::with('company')->whereId($branch_id)->whereDeleted(false)->first();   
        $company_code = $branch->company->code;   

        // search for so_no with same branch code, company code, current date and get the last record 
        $sales = Sales::where('so_no', 'like', 'SO-' . $branch->cost_center . '-' . Str::upper($company_code) . '-' . Carbon::now()->format('Ymd') . '-%')->latest()->first();

        // get the last 4 character of so number
        $last = isset($sales->so_no) ? substr($sales->so_no, strlen($sales->so_no)-4) : 0;
        // remove leading zeros, then increment by 1
        $last_number = $last == 0 ? 1 : ltrim($last, 0) + 1;

        $check = isset($sales->so_no) && strpos($sales->so_no, Carbon::now()->format('Ymd')); // get current date in yyyymmdd format and compare with the last so_no

        if($check) { // true? increment by 1
            return 'SO-' . $branch->cost_center . '-' . Str::upper($company_code) . '-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 4) . $last_number, - 4);
        } else { // false? start at 1 again with new date
            return 'SO-' . $branch->cost_center . '-' . Str::upper($company_code) . '-' . Carbon::now()->format('Ymd') . '-' . substr(str_repeat(0, 4) . '1', - 4);
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

    public static function transaction_history($record_id, $record_uuid, $transaction_type_id, $status_id, $so_no, $module, $event_name, $remarks) {
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


    // should I store this in cache/session or in login method to prevent querying multiple times on every page loads?
    public static function get_user_role_name() {
        $user = User::with('role')->whereId(Auth::user()->id)->firstOrFail();

        // store in session to prevent repeated query on page refresh and/or page transition
        Session::put('role_name', $user->role->name);

        return $user->role->name;
    }

    public static function get_user_branch_name() {
        // there are users who have multiple branches
        $user = User::with('branch')->whereId(Auth::user()->id)->firstOrFail();

        $branch_name = '';

        if(!empty($user->branch_id)) {
            $explode = explode(',', $user->branch_id);

            if(count($explode) > 1) {
                for($i = 0; $i < count($explode); $i++) {
                    // add separator in between branch names, if loop reaches the last, do not add a separator
                    $separator = $i != count($explode) - 1 ? ' / ' : '';

                    // get the branch name only, not as collection
                    $branches = Branch::whereId($explode[$i])->value('name'); 

                    // append if multiple
                    $branch_name .= $branches . $separator;
                }
            } else {
                $branch_name = $user->branch->name;
            }
        }

        // store in session to prevent repeated query on page refresh and/or page transition
        Session::put('branch_name', $branch_name);

        return $branch_name; // this can be single or multiple with '/' as separator
    }

    public static function get_company_id_by_branch_id($branch_id) {
        return Branch::whereId($branch_id)->whereDeleted(false)->first()->company_id;
    }

    public static function get_company_name_by_branch_id($branch_id) {
        $branch = Branch::with('company')->whereId($branch_id)->whereDeleted(false)->first();
        return $branch->company->name;
    }

    public static function get_branch_name_by_id($id) {
        $ids = explode(',', $id);
        $branch_names = [];
        foreach ($ids as $branch_id) {
            $branch = Branch::whereId($branch_id)->whereDeleted(false)->first();
            if ($branch) {
                $branch_names[] = $branch->name;
            }
        }
        return implode(',', $branch_names);  //do not add space between ','
    }

    public static function get_company_names_by_id($ids) {
        $ids = explode(',', $ids);
        $company_names = [];
        foreach ($ids as $company_id) {
            $company = Company::whereId($company_id)->whereDeleted(false)->first();
            if ($company) {
                $company_names[] = $company->name;
            }
        }
        return implode(',', $company_names); //do not add space between ','
    }

    public static function get_erpnext_data($param) {
        $client = new Client();

        try {
            $response = $client->get(env('ERPNEXT_URL') . $param, [
                'headers' => [
                    'Authorization' => 'Token ' . env('ERPNEXT_API_KEY') . ':' . env('ERPNEXT_API_SECRET'),
                    'Accept' => 'application/json', 
                ],
            ]);

            return [
                'status_code' => $response->getStatusCode(),
                'data' => json_decode($response->getBody(), true),
            ];
        } catch (\Exception $e) {
            return [
                'status_code' => 404,
                'error' => $e->getMessage(),
            ];
        }
    }

    public static function get_si_assignment_no($id) {
        $si_assignment_detail = SalesInvoiceAssignmentDetail::whereId($id)->first();
        return $si_assignment_detail->series_number;
    }

    public static function get_distributor_name_by_bcid($bcid) {
        $distributor = Distributor::whereBcid($bcid)->first();
        return $distributor->name;
    }
}