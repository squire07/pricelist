<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Helpers\Helper;
use App\Models\History;
use App\Models\Sales;
use App\Models\SalesInvoiceForValidation;
use App\Models\Payload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use GuzzleHttp\Client;

class ForValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get current users branch ids 
        $user_branch = User::whereId(Auth::user()->id)->value('branch_id');

        $sales_orders = Sales::with('status','transaction_type')
                            ->where(function ($query) use ($request) {
                                if ($request->has('daterange')) {
                                    $date = explode(' - ', $request->daterange);
                                    $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                                    $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
                        
                                    // Apply the whereBetween condition
                                    $query->whereBetween('created_at', [$from, $to]);
                                }
                            })
                            ->whereStatusId(5)
                            ->whereDeleted(false)
                            ->when(!empty($user_branch), function($query) use ($user_branch) {
                                $query->whereIn('branch_id', explode(',',$user_branch));
                            })
                            ->orderByDesc('id')
                            ->get();

        return view('SalesInvoice.for_validation.index', compact('sales_orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $sales_order = Sales::with('payment')->whereUuid($uuid)
                        ->whereStatusId(5)
                        ->with('transaction_type')
                        ->with('sales_details', function($query) {
                            $query->where('deleted',0);
                        })->firstOrFail();

        // convert the details from json_object to array object
        if(isset($sales_order->payment->details)) {
            $sales_order->payment->details = json_decode($sales_order->payment->details,true);
        }

        $histories = History::whereUuid($sales_order->uuid)->whereDeleted(false)->get();
        
        return view('SalesInvoice.for_validation.show', compact('sales_order','histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoiceForValidation $salesInvoiceForValidation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $uuid = $request->uuid ?? $uuid;
        
        $sales = Sales::whereUuid($uuid)->whereDeleted(false)->firstOrFail();  

        // check if request contains status_id = 3
        if(isset($request->status_id) && $request->status_id == 3) { // Cancel
            $sales->status_id = $request->status_id;
            $sales->si_remarks = $request->si_remarks;
            $sales->updated_by = Auth::user()->name; // updated_at will be automatically filled by laravel
            if($sales->update()) {
                // pass the message to user if the update is successful
                Helper::transaction_history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Invoice', 'Cancel Sales Invoice', $sales->si_remarks);
                return redirect('sales-invoice/for-validation')->with('success', $sales->so_no . ' successfully marked Cancelled');
            } else {
                return redirect('sales-invoice/for-validation')->with('error', 'Unable to mark this transaction as cancelled! Please contact your administrator.');
            }

        } else if(isset($request->status_id) && $request->status_id == 5) { // validate OR `for posting`

            // 1) check distributor in erpnext if existing
            $distributor_name = Helper::get_distributor_name_by_bcid($sales->bcid);
            $distributor_param = '/api/resource/Customer'; // if POST, do not add '/' at the end 

            $distributor_data = Helper::get_erpnext_data($distributor_param . '/' . $distributor_name);

            // 2) get the payload
            $payload = Payload::whereUuid($sales->uuid)->first();

            // 3) post the customer if not existing in erpnext
            if($distributor_data['status_code'] == 404) {
                $post_customer = Helper::post_erpnext_data($distributor_param, $payload->distributor);
                // update payload with response 
                $payload->distributor_response = $post_customer->getStatusCode();         
                $payload->update();
            }


            if(isset($post_customer) && $post_customer->getStatusCode() == 404) {
                // !IMPORTANT: Posting SO and SI in ERPNext requires customer 
                return redirect('sales-invoice/for-validation')->with('error', 'Could not add customer to ERPNext! Please contact your administrator.');
            
            } else {
                // After posting a new customer (distributor), we need to post the SO and SI

                // 3) Post the SO to erpnext
                $so_param = '/api/resource/Sales Order'; // if POST, do not add '/' at the end 
                // post the so payload to erpnext
                $post_so = Helper::post_erpnext_data($so_param, $payload->so);

                // update payload with response
                $payload->so_response = $post_so->getStatusCode();
                $payload->update();

                // 4) Post the SI to erpnext
                $si_param = '/api/resource/Sales Invoice'; // if POST, do not add '/' at the end 
                // post the so payload to erpnext
                $post_si = Helper::post_erpnext_data($si_param, $payload->si);
                
                // update payload with response
                $payload->si_response = $post_si->getStatusCode();
                $payload->update();

                // mark as released
                $sales->status_id = 4;

                if($sales->update()) {
                    if($post_so->getStatusCode() == 200) {
                        return redirect('sales-invoice/for-validation')->with('success', 'Sales order was successfully recorded to ERPNext!');
                    }
                } else {
                    return redirect('sales-invoice/for-validation')->with('error', 'Unable to add SO and SI at ERPNext! Please contact your administrator.');
                }
            }
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoiceForValidation $salesInvoiceForValidation)
    {
        //
    }

    public function sales_invoice_for_validation_list() 
    {
        $sales_invoice_for_validation = Sales::with('status','transaction_type')->whereIn('status_id', [4])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice_for_validation)->toJson(); 
    }
}
