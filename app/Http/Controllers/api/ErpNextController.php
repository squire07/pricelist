<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Sales;
use App\Helpers\Helper;

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

            // tag the Sales Invoice as cancelled
            $sales = Sales::whereSiNo($si_number)->first();
            if($sales) {
                $sales->status_id = 3;

                if($sales->update()) {
                    // create log
                    Helper::erp_transaction_history($sales->id, $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Invoice', 'Cancel Sales Invoice', $doc_name . ' - Cancelled in ERPNext', $erpnext_user);
                }
            }
        } 
        
        return response()->json(['message' => 'Data received successfully']);
    }
}
