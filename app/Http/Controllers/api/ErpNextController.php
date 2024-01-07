<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\History;
use App\Models\Nuc;
use App\Models\Sales;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ErpNextController extends Controller
{
    public function cancel_invoice(Request $request) 
    {
        $json_string = key($request->all());

        // sanitize
        $json_string = str_replace(':_', ':', $json_string);
        $json_string = str_replace(',_', ',', $json_string);

        // Decode the JSON string
        $json_data = json_decode($json_string, true);

        Log::info($json_data);

        if ($json_data !== null) {
            // Extract the value of glv2_si_number
            $doc_name = $json_data['name'];
            $si_number = $json_data['glv2_si_number'];
            $erpnext_user = $json_data['modified_by'];

            // tag the Sales Invoice as cancelled and the NUC as cancelled if there is nuc record
            $sales = Sales::whereSiNo($si_number)
                        ->first();
            if($sales) {
                $sales->status_id = 3; // mark as cancelled

                if($sales->update()) {

                    $history = new History();
                    $history->record_id = $sales->id;
                    $history->uuid = $sales->uuid;
                    $history->transaction_type_id = $sales->transaction_type_id;
                    $history->status_id = $sales->status_id;
                    $history->so_no = $sales->so_no;
                    $history->module = 'Sales Invoice';
                    $history->event_name = 'Cancel Sales Invoice';
                    $history->remarks = $doc_name . ' - Cancelled in ERPNext';
                    $history->created_by = $erpnext_user;
                    $history->updated_by = $erpnext_user;
                    $history->created_at = Carbon::now();
                    $history->updated_at = Carbon::now();
                    $history->save();

                    Log::info('HISTORY =============================================');
                    Log::info($history);


                    //create global token to retrieve product details
                    $global_token = Http::asForm()->post(env('PRIME_IDP'), [
                        'username' => 'spectator',
                        'password' => '6fYR72',
                        'grant_type' => 'password',
                        'client_secret' => 'TDOXe4BPfSv-OJ_Pbb4tshdQETl0EKJpkVPeoHKf6dg',
                        'client_id' => 'prime-apps', 
                        'Content-type' => 'application/x-www-form-urlencoded; charset=utf-8'
                    ]);

                    // cancel the nuc from the NUC table
                    $nuc = Nuc::whereUuid($sales->uuid)->whereIn('status', [0,1])->first();
                    $nuc->status = 2; // 2 - cancelled;

                    if($nuc->update()){

                        // revert the nuc from prime
                        if(in_array($sales->transaction_type_id, Helper::get_upc_ubc_transaction_ids())) {
                            // UBC and UPC
                            // revert to NewULCreditLimit column

                            $res = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => 'Bearer ' . $global_token['access_token'], 'Accept' => 'application/json'])
                                            ->post(env('PRIME_API') . 'revertnuccredit/newulcreditlimit/' . $nuc->bcid . '/' . $total_nuc . '/' . $nuc->branch . '/' . $nuc->oid);

                            Log::info($res);
                            if($res->status() == 200) {
                                // update nuc
                                $nuc->status = 2; // Cancelled
                                $nuc->updated_at = Carbon::now()->toDateTimeString();
                                $nuc->update();
                            }

                        } else {
                            // RS
                            // revert to NewULCashPurchase column
                            $res = Http::withHeaders(['Content-Type' => 'application/json','Authorization' => 'Bearer ' . $global_token['access_token'], 'Accept' => 'application/json'])
                                            ->post(env('PRIME_API') . 'revertnuccredit/newulcashpurchases/' . $nuc->bcid . '/' . $total_nuc . '/' . $nuc->branch . '/' . $nuc->oid);
                                  
                            Log::info($res);
                            if($res->status() == 200) {
                                // update nuc
                                $nuc->status = 2; // Cancelled
                                $nuc->updated_at = Carbon::now()->toDateTimeString();
                                $nuc->update();
                            }
                        }
                    }

                    // create log
                    //Helper::erp_transaction_history($sales->id, $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Invoice', 'Cancel Sales Invoice', $doc_name . ' - Cancelled in ERPNext', $erpnext_user);
                }
            }
        } 
        return response()->json(['message' => 'Data received successfully']);
    }
}
