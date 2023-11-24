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
                // // After posting a new customer (distributor), we need to post the SO and SI

                // // 3) Post the SO to erpnext
                // // do {
                //     $so_param = '/api/resource/Sales Order'; // if POST, do not add '/' at the end 
                //     // post the so payload to erpnext
                //     $post_so = Helper::post_erpnext_data($so_param, $payload->so);

                //     dump($post_so);

                //     // update payload with response
                //     $payload->so_response_status = $post_so->getStatusCode();
                //     $payload->so_response_body = $post_so->getBody(); 
                //     $payload->update();

                // // } while ($payload->so_response_status !== 200);

                //     /* 
                //     *  IMPORTANT!
                //     *  - lets link sales order and si using the sales order name from reponse
                //     *  - update the sales invoice payload and add the sales order `name` which can be found at so_response body 
                //     */

                //     // 3.1) Get the sales order response body
                //         $so_response_body = $payload->so_response;

                //         // Define the regular expression pattern
                //         $data = json_decode($payload->so_response_body, true);

                //         // Use preg_match to find the match
                //         $so_doc_name = $data['data']['name'] ?? null;

                //     // 3.2) add the `so_doc_name` to `si payload`

                //         // update the si payload with so_doc_name before posting to erpnext
                //         $data = json_decode($payload->si, true);

                //         // Add "sales_order" key to each item in the "items" array
                //         foreach ($data['items'] as &$item) {
                //             $item['sales_order'] = $so_doc_name; 
                //         }
                        
                //         // Convert back to JSON
                //         $payload->si = json_encode($data);
                //         $payload->update();
                        
                    
                // // 4) Post the SI to erpnext
                // // do {
                //     $si_param = '/api/resource/Sales Invoice'; // if POST, do not add '/' at the end 
                //     // post the so payload to erpnext
                //     $post_si = Helper::post_erpnext_data($si_param, $payload->si);
                    
                //     // // update payload with response
                //     $payload->si_response_status = $post_si->getStatusCode();
                //     $payload->si_response_body = $post_si->getBody();
                //     $payload->update();
                // // } while ($payload->si_response_status !== 200);

                //     /*
                //     *  Create Payment Entry
                //     *  link the sales invoice with payment entry using sales invoice name
                //     */

                //     // 4.1) Get the sales income response body
                //         $si_response_body = $payload->si_response;

                //         // Define the regular expression pattern
                //         $data = json_decode($payload->si_response_body, true);

                //         // Use preg_match to find the match
                //         $si_doc_name = $data['data']['name'] ?? null;

                //     // 4.2) add the `si_doc_name` to `payment payload`

                //         // update the payment payload with si_doc_name before posting to erpnext
                //         // json is formatted to handle sub array 
                //         $datas = json_decode($payload->payment, true);

                //         foreach($datas as $data) {
                //             // Add "sales_order" key to each item in the "items" array
                //             foreach ($data['references'] as &$reference) {
                //                 $reference['reference_name'] = $si_doc_name; 
                //             }
                //         }
                        
                //         // Convert back to JSON
                //         $payload->payment = json_encode($datas);
                //         $payload->update();


                // // 5) Post the Payment Entry to erpnext
                // $payment_param = '/api/resource/Payment Entry'; // if POST, do not add '/' at the end 
                // // post the so payload to erpnext
                // $post_payment = Helper::post_erpnext_data($payment_param, $payload->payment);
                
                // // // update payload with response
                // $payload->payment_response_status = $post_payment->getStatusCode();
                // $payload->payment_response_body = $post_payment->getBody();
                // $payload->update();


                // mark as released
                $sales->status_id = 4;

                if($sales->update()) {
                    //if($post_so->getStatusCode() == 200) {
                        return redirect('sales-invoice/for-validation')->with('success', 'Sales order was successfully recorded to ERPNext!');
                    //}
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

    public function print($uuid) 
    {
        //sleep(3); // allow x seconds interval before getting the sales details

        $sales_order = Sales::with('payment')
                        ->whereUuid($uuid)
                        ->whereStatusId(5)
                        ->with('transaction_type')
                        ->with('sales_details', function($query) {
                            $query->where('deleted',0);
                        })->firstOrFail();

        $sales_order->total_item_count = $sales_order->sales_details->sum('quantity');
        $sales_order->amount_tendered = number_format($sales_order->payment['total_amount'] + $sales_order->payment['change'], 2, '.', ',');

        if($sales_order->company_id == 3) {
            return view('SalesInvoice.print.local', compact('sales_order'));
        } else {
            return view('SalesInvoice.print.premier', compact('sales_order'));
        }
    }
}
