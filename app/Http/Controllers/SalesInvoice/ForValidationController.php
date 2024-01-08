<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Helpers\Helper;
use App\Models\History;
use App\Models\Sales;
use App\Models\SalesInvoiceForValidation;
use App\Models\Payload;
use App\Models\Payment;
use App\Models\PaymentMethod;
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
        $sales_order = Sales::with('branch','payment','transaction_type','income_expense_account','payload')
                            ->with(['income_expense_account' => function($query) use ($uuid) {

                                // Fetch the sales order inside the closure
                                $sales_order = Sales::whereUuid($uuid)->firstOrFail();

                                $query->where('company_id', $sales_order->company_id);
                            }])
                            ->with('sales_details', function($query) {
                                $query->where('deleted',0);
                            })
                            ->whereUuid($uuid)
                            ->whereStatusId(5)
                            ->whereDeleted(false)
                            ->firstOrFail();

        // convert the details from json_object to array object
        if(isset($sales_order->payment->details)) {
            $sales_order->payment->details = json_decode($sales_order->payment->details,true);
        }

        $histories = History::whereUuid($sales_order->uuid)->whereDeleted(false)->get();

   
        $has_issue = false;
        $message_issue = null;

        // check if the transaction has income and expense account 
        if ($sales_order->relationLoaded('income_expense_account')) {
            if (!$sales_order->income_expense_account || $sales_order->income_expense_account->income_account === null || $sales_order->income_expense_account->expense_account === null) {
                $has_issue = true;
                $message_issue .= '&bull;&nbsp;Income and Expense Account is required for ' . $sales_order->transaction_type->name . '<br>';
            }
        } 
        // check if payment method is not cash AND reference number exists
        if ($sales_order->relationLoaded('payment')) {
            // json_decode has already been applied at $sales_order->payment->details
            foreach($sales_order->payment->details as $payment) {
                $is_cash = in_array($payment['name'], Helper::get_is_cash_payment_names()); 
                $ref_no = empty($payment['ref_no']);
                if(!$is_cash && $ref_no) {
                    $has_issue = true;
                    $message_issue .= '&bull;&nbsp;Reference number is required for ' . $payment['name'] . '<br>';
                }
            }
        }
        // check if there is/are stock for each item in warehouse
        if ($sales_order->relationLoaded('sales_details') && $sales_order->relationLoaded('branch')) {

            $todays_date = Carbon::now()->format('Y-m-d'); // do not change the date format!


            // check if the sales order transaction type is NOT Product Pack
            if(!in_array($sales_order->transaction_type_id, Helper::get_product_assembly_ids())) {
                $items = '';

                foreach($sales_order->sales_details as $item) {
                    $param = '/api/resource/Stock Ledger Entry?filters=[["item_code", "=", "' . $item->item_code . '"], ["posting_date", "<=", "' . $todays_date . '"], ["warehouse", "=", "' . $sales_order->branch->warehouse . '"]]&fields=["item_code", "warehouse", "sum(actual_qty) as total_qty"]';
                    
                    $item_inventory = Helper::get_erpnext_data($param);

                    if($item_inventory->getStatusCode() == 200) {
                        $data = json_decode($item_inventory->getBody()->getContents(), true);
                        $item_inventory = $data['data']; // note: this has status_code and data AND the server response is always 200
                        if($item_inventory[0]['total_qty'] == null || $item_inventory[0]['total_qty'] <= $item->quantity) {
                            $has_issue = true;
                            $items .= '&#8594; ' . $item->item_code . ' - ' . $item->item_name . '<br>';
                        }
                    }
                }   

                $item_count = count($sales_order->sales_details) > 1 ? 's':'';
                
                if($has_issue) {
                    $message_issue .= '&bull;&nbsp;Warehouse ' . $sales_order->branch->warehouse . ' has insufficient quantity for item' . $item_count . ': <br>' . $items;
                }
            } 
        }

        // for editing payment method using modal 
        $payment_methods = PaymentMethod::whereDeleted(0)
                                ->whereCompanyId($sales_order->company_id)
                                ->orderBy('name')
                                ->get();

        if($has_issue) {
            return view('SalesInvoice.for_validation.show', compact('sales_order','histories','payment_methods'))->with('error', $message_issue);
        } else {
            return view('SalesInvoice.for_validation.show', compact('sales_order','histories','payment_methods'));
        }
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
        
        $sales = Sales::with('branch','payment','transaction_type','income_expense_account')
                            ->with('sales_details', function($query) {
                                $query->where('deleted',0);
                            })
                            ->whereUuid($uuid)
                            //->whereStatusId(5)
                            ->whereDeleted(false)
                            ->firstOrFail();  

        if($sales->version == $request->version) {
            // check if request contains status_id = 3
            if(isset($request->status_id) && $request->status_id == 3) { // Cancel
                $sales->status_id = $request->status_id;
                $sales->si_remarks = $request->si_remarks;
                $sales->updated_by = Auth::user()->name; // updated_at will be automatically filled by laravel
                $sales->version = $sales->version + 1;
                if($sales->update()) {
                    // revert the nuc points here
                    







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
                    
                    $distributor_data = Helper::get_erpnext_data($distributor_param . '/' . trim($distributor_name));

                // 2) get the payload
                    $payload = Payload::whereUuid($sales->uuid)->first();


                    if($payload) {
                    // 3) post the customer if not existing in erpnext
                        if(method_exists($distributor_data, 'getCode') && $distributor_data->getCode() == 404) {
                            try {
                                $post_customer = Helper::post_erpnext_data($distributor_param, $payload->distributor);
                                // update payload with response 
                                
                                $payload->update([
                                    'distributor_response_status' => $post_customer->getStatusCode(),
                                    'distributor_response_body' => $post_customer->getBody()->getContents(),
                                ]);
                            } catch (\GuzzleHttp\Exception\ClientException $e) {
                                $payload->update([
                                    'distributor_response_status' => $e->getResponse()->getStatusCode(),
                                    'distributor_response_body' => $e->getResponse()->getBody()->getContents(),
                                ]);
                            }
                        }
                        

                        // 4) if error in posting customer to erpnext
                        if(isset($post_customer) && $post_customer->getStatusCode() == 404) {
                            // !IMPORTANT: Posting SO and SI in ERPNext requires customer 

                            $sales->version = $sales->version + 1;
                            $sales->update();

                            return redirect('sales-invoice/for-validation')->with('error', 'Unable not add customer in ERPNext! Please contact your administrator.');
                        
                        } else {
                            // After posting a new customer (distributor), we need to post the SO and SI


                            $statusCode = null;
                            // 5) Post the SO to erpnext
                                $so_param = '/api/resource/Sales Order'; // if POST, do not add '/' at the end 
                                try {
                                    $post_so = Helper::post_erpnext_data($so_param, $payload->so);
                                    if ($post_so->getStatusCode() == 200) {
                                        $payload->update([
                                            'so_response_status' => $post_so->getStatusCode(),
                                            'so_response_body' => $post_so->getBody(),
                                        ]);
                                    } 
                                } catch (\GuzzleHttp\Exception\ClientException $e) {
                                    $payload->update([
                                        'so_response_status' => $e->getResponse()->getStatusCode(),
                                        'so_response_body' => $e->getResponse()->getBody()->getContents(),
                                    ]);

                                    $sales->version = $sales->version + 1;
                                    $sales->update();

                                    return redirect('sales-invoice/for-validation')->with('error', 'Unable to add Sales Order in ERPNext! Please contact your administrator.');
                                }

                                /* 
                                *  IMPORTANT!
                                *  - lets link sales order and si using the sales order name from reponse
                                *  - update the sales invoice payload and add the sales order `name` which can be found at so_response body 
                                */

                                // 5.1) Get the sales order response body
                                    $so_response_body = $payload->so_response;

                                    // Define the regular expression pattern
                                    $so_data = json_decode($payload->so_response_body, true);

                                    // Use preg_match to find the match
                                    $so_doc_name = $so_data['data']['name'] ?? null;

                                // 5.2) add the `so_doc_name` to `si payload`

                                    // update the si payload with so_doc_name before posting to erpnext
                                    $si_data = json_decode($payload->si, true);

                                    // Add "sales_order" key to each item in the "items" array

                                    if(!in_array($sales->transaction_type_id, Helper::get_product_assembly_ids())) {
                                        
                                        foreach ($si_data['items'] as &$item) {
                                            $item['sales_order'] = $so_doc_name; 
                                        }

                                    } else {

                                        /*
                                        * ===================================================================
                                        *   For Product Pack and UNO Cafe
                                        *   1. get the SO response body payload and get the "packed_items" array
                                        *   2. update the SI payload and add the "packed_items" in the array
                                        * ===================================================================
                                        */

                                        $so_data = json_decode($payload->so_response_body, true);

                                        // extract the "packed_items" array from so payload
                                        $so_packed_items = $so_data['data']['packed_items'];
                                        
                                        // create a empty array that will handle all the packed_items with batch_id
                                        $packed_items = array();
                                        $item = array();

                                        foreach($so_packed_items as $packed) {
                                            // pass the item code to helper function and get the batch id
                                            $batch_id = Helper::get_batch_id($packed['item_code']);

                                            $item['item_code'] = $packed['item_code'];
                                            $item['batch_no'] = $batch_id;
    
                                            array_push($packed_items, $item);
                                        }

                                        $si_data['packed_items'] = $packed_items;
                                    }
                                    
                                    // Convert back to JSON
                                    $payload->update([
                                        'si' => json_encode($si_data, JSON_UNESCAPED_SLASHES)
                                    ]);
        
                                
                            // 6) Post the SI to erpnext
                                $si_param = '/api/resource/Sales Invoice'; // if POST, do not add '/' at the end 
                                try {
                                    $post_si = Helper::post_erpnext_data($si_param, $payload->si);
                                    if ($post_si->getStatusCode() == 200) {
                                        $payload->update([
                                            'si_response_status' => $post_si->getStatusCode(),
                                            'si_response_body' => $post_si->getBody(),
                                        ]);
                                    } 
                                } catch (\GuzzleHttp\Exception\ClientException $e) {
                                    $payload->update([
                                        'si_response_status' => $e->getResponse()->getStatusCode(),
                                        'si_response_body' => $e->getResponse()->getBody()->getContents(),
                                    ]);

                                    $sales->version = $sales->version + 1;
                                    $sales->update();
                            
                                    return redirect('sales-invoice/for-validation')->with('error', 'Unable to add Sales Invoice in ERPNext! Please contact your administrator.');
                                }


                                /*
                                *  Create Payment Entry
                                *  link the sales invoice with payment entry using sales invoice name
                                */

                                // 6.1) Get the sales invoice response body
                                    $si_response_body = $payload->si_response;

                                    // decode
                                    $data = json_decode($payload->si_response_body, true);

                                    // get the si doc name
                                    $si_doc_name = $data['data']['name'] ?? null;


                                // 6.2) add a cashiers comment 
                                    if($payload->comment != null) {
                                        $comments = json_decode($payload->comment, true);

                                        foreach($comments as &$comment) {
                                            $comments['reference_name'] = $si_doc_name;
                                        }

                                        // Convert back to JSON
                                        $payload->update([
                                            'comment' => json_encode($comments, JSON_UNESCAPED_SLASHES)
                                        ]);
                                    }



                                // 6.3) add the `si_doc_name` to `payment payload`

                                    // update the payment payload with si_doc_name before posting to erpnext
                                    // json is formatted to handle sub array 
                                    $payments = json_decode($payload->payment, true);

                                    foreach($payments as &$payment) {
                                        // Add "sales_order" key to each item in the "items" array
                                        foreach ($payment['references'] as &$reference) {
                                            $reference['reference_name'] = $si_doc_name; 
                                        }
                                    }
                                    
                                    // Convert back to JSON
                                    $payload->update([
                                        'payment' => json_encode($payments, JSON_UNESCAPED_SLASHES)
                                    ]);




                            // 7) Post the Comment to erpnext
                                if($payload->comment != null) {
                                    $comment_param = '/api/resource/Comment'; // if POST, do not add '/' at the end 
                    
                                    try {
                                        $post_comment = Helper::post_erpnext_data($comment_param, $payload->comment);
                                        if ($post_comment->getStatusCode() == 200) {
                                            $payload->update([
                                                'comment_status' => $post_comment->getStatusCode(),
                                                'comment_body' => $post_comment->getBody(),
                                            ]);
                                        } 
                                    } catch (\GuzzleHttp\Exception\ClientException $e) {
                                        $payload->update([
                                            'comment_status' => $e->getResponse()->getStatusCode(),
                                            'comment_body' => $e->getResponse()->getBody()->getContents(),
                                        ]);

                                        $sales->version = $sales->version + 1;
                                        $sales->update();

                                        return redirect('sales-invoice/for-validation')->with('error', 'Unable to add comment to sales invoice in ERPNext! Please contact your administrator.');
                                    }
                                }
                                


                            // 8) Post the Payment Entry to erpnext
                                $payment_param = '/api/resource/Payment Entry'; // if POST, do not add '/' at the end 
                                // post the so payload to erpnext; handle multiple payment
                                $payment_obj = json_decode($payload->payment, true); // decode again as this obj has been updated above

                                foreach($payment_obj as $payload_payment) {
                                    try {
                                        $post_payment = Helper::post_erpnext_data($payment_param, json_encode($payload_payment, JSON_UNESCAPED_SLASHES));
                                        if ($post_payment->getStatusCode() == 200) {
                                            $payload->update([
                                                'payment_response_status' => $post_payment->getStatusCode(),
                                                'payment_response_body' => $post_payment->getBody(),
                                            ]);
                                        } 
                                    } catch (\GuzzleHttp\Exception\ClientException $e) {
                                        $payload->update([
                                            'payment_response_status' => $e->getResponse()->getStatusCode(),
                                            'payment_response_body' => $e->getResponse()->getBody()->getContents(),
                                        ]);

                                        $sales->version = $sales->version + 1;
                                        $sales->update();
                        
                                        return redirect('sales-invoice/for-validation')->with('error', 'Unable to add Payment Details in ERPNext! Please contact your administrator.');
                                    }
                                }


                            // 9) Update the status of Sales Order to 'completed'
                                // $so_response_body = $payload->so_response;

                                // // Define the regular expression pattern
                                // $data = json_decode($payload->so_response_body, true);

                                // // Use preg_match to find the match
                                // $so_doc_name = $data['data']['name'] ?? null;

                                // $so_param = '/api/resource/Sales Order/' . $so_doc_name;
                                // $so_status_update = "{'status':'Completed'}"; // this will be decoded by the function
                                // try {
                                //     $so_status_put = Helper::put_erpnext_data($so_param, $so_status_update);
                                // } catch (\GuzzleHttp\Exception\ClientException $e) {
                                //     return false;
                                // }


                            // mark as released
                            $sales->status_id = 4;
                            $sales->version = $sales->version + 1;

                            if($sales->update()) {

                                // pass the message to user if the update is successful
                                Helper::transaction_history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->si_no, 'Sales Invoice', 'Validate Sales Invoice', $sales->si_remarks);

                                if($post_so->getStatusCode() == 200) {
                                    return redirect('sales-invoice/for-validation')->with('success', 'Sales order was successfully recorded to ERPNext!');
                                }
                            } else {
                                return redirect('sales-invoice/for-validation')->with('error', 'Unable to add SO and SI in ERPNext! Please contact your administrator.');
                            }
                        }         
                        
                    } else {
                        return redirect('sales-invoice/for-validation')->with('error', 'No Payload Data Found! Please contact your administrator.');
                    }
            } 
        } else {
            return redirect('sales-invoice/for-validation')->with('error', 'This sales invoice was recently modified by another user!');
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

    /*
    *   Do not combine with the update() method
    */
    public function update_payment_details(Request $request)
    {
        $payment = Payment::whereId($request->payment_id)->first();

        $sales = Sales::whereUuid($payment->uuid)->first();
        
        $payment_details = json_decode($payment->details,true);

        // will be used in log history
        $old_payment_method_name = $payment_details[0]['name'];
        $old_payment_ref_no = $payment_details[0]['ref_no'];

        // get the payment method name by id
        $payment_method = PaymentMethod::whereId($request->payment_method_id)->first();

        // update the payment_details (json);
        $payment_details[0]['id'] = $payment_method->id;
        $payment_details[0]['name'] = $payment_method->name;
        $payment_details[0]['ref_no'] = $request->ref_no;

        // finally, update the payment_type and details from [Payment] table
        $payment->payment_type = $payment_method->name;
        $payment->details = $payment_details;

        if($payment->update()) {
            
            // update the payload details as well; Sales UUID = Payment UUID = Payload UUID
            $payload = Payload::whereDeleted(0)->whereUuid($payment->uuid)->first();

            // update si payload
            $payload->si = Helper::create_si_payload($sales->id);
            
            // update payment payload
            $payload->payment = Helper::create_payment_payload($payment->sales_id);
            $payload->update();

            // log the update
            $old_ref_no = $old_payment_ref_no != '' ? ' - ' . $old_payment_ref_no : '';
            $remarks = $old_payment_method_name . $old_ref_no . ' to ' . $payment_method->name . ' - ' . $request->ref_no; 
            Helper::transaction_history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->si_no, 'Sales Invoice', 'Update Payment Details', $remarks);

            return redirect()->back()->with('success', 'Payment details updated');
        } else {
            return redirect()->back()->with('error', 'Unable to update payment details. Please contact system administrator.');
        }
    }
}
