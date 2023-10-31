<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Models\Sales;
use App\Helpers\Helper;
use App\Models\History;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceAssignment;
use App\Models\SalesInvoiceAssignmentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ForInvoicingController extends Controller
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
                            ->whereStatusId(2)
                            ->whereDeleted(false)
                            ->when(!empty($user_branch), function($query) use ($user_branch) {
                                $query->whereIn('branch_id', explode(',',$user_branch));
                            })
                            ->orderByDesc('id')
                            ->get();

        return view('SalesInvoice.for_invoicing.index', compact('sales_orders'));
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
        $sales_order = Sales::whereUuid($uuid)
                        ->whereStatusId(2)
                        ->with('transaction_type')
                        ->with('sales_details', function($query) {
                            $query->where('deleted',0);
                        })->firstOrFail();
        
        $histories = History::whereUuid($sales_order->uuid)->whereDeleted(false)->get();
        
        return view('SalesInvoice.for_invoicing.show', compact('sales_order','histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales, $uuid)
    {
        $sales_order = Sales::with('sales_details','transaction_type','status')->whereUuid($uuid)->firstOrFail();

        /* Based on cashier's branch id
        *  Branch id 1,7 = West Insula Local and Premier
        *  Branch id 6 = Ecomm Local; 12 = Ecomm Premier
        *  Branch id LO = Local - all branches except West Insula; PR = Premier - all branches except West Insula
        *  Note: Only cashier, admin and super admin can get the payment list.
        */

        // check users branch id: null, single value, explode
        $exploded = Auth::user()->branch_id != null ? array_map('trim', explode(',', Auth::user()->branch_id)) : null;

        $payment_types = PaymentMethod::whereDeleted(false)
                            ->where('status_id', 6)
                            ->where(function ($query) use ($exploded) {
                                if ($exploded) {
                                    foreach ($exploded as $branch_id) {
                                        $query->orWhereRaw('FIND_IN_SET(?, branch_id)', [$branch_id]);
                                    }
                                }
                            })
                            ->get();

        // get the next available sales invoice assignment number by user's id and sales order branch id
        $si_assignment = SalesInvoiceAssignment::whereDeleted(false)
                            ->whereUserId(Auth::user()->id) //Auth::user()->id
                            // ->whereBranchId($sales_order->branch_id) //$sales_order->branch_id
                            ->with('booklet_details', function($query) {
                                $query->where('used',0)->first();
                            })
                            ->first();
        
        // needs to refactor this
        if(!is_null($si_assignment)) {
            $used = SalesInvoiceAssignmentDetail::whereDeleted(false)
                        ->whereSalesInvoiceAssignmentId($si_assignment->id)
                        ->whereUsed(0)
                        ->get();
        
            // show the alert if remaining invoice is less than equal to 20%
            $usedCount = count($used); // Get the count of $used
            $totalCount = $si_assignment->count ?? 0; // Get the total count of invoices assigned
            $percentage = ($totalCount > 0) ? ($usedCount / $totalCount) * 100 : 0; // Calculate percentage

            if ($usedCount === 0) {
                $alert_type = 'danger';
            } else if ($percentage <= 20) {
                $alert_type = 'warning';
            } else {
                $alert_type = null;
            }
        } else {
            $alert_type = 'danger';
        }

        return view('SalesInvoice.for_invoicing.edit', compact('sales_order','payment_types','si_assignment','alert_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $uuid = $request->uuid ?? $uuid;
        
        $sales = Sales::whereUuid($uuid)->whereDeleted(false)->firstOrFail();  

        // check if request contains status_id = 1
        if(isset($request->status_id) && $request->status_id == 1) { // Draft
            $sales->status_id = $request->status_id;
            $sales->so_remarks = $request->so_remarks;
            $sales->updated_by = Auth::user()->name; // updated_at will be automatically filled by laravel
            if($sales->update()) {
                // pass the message to user if the update is successful
                $message = $sales->so_no . ' successfully returned to Draft!';
            }

            Helper::transaction_history($sales->id, $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Invoice', 'Return Sales Order to Draft', $sales->so_remarks);

            // redirect to index page with dynamic message coming from different statuses
            return redirect('sales-invoice/for-invoice')->with(['success' => $message]);

        } else if(isset($request->status_id) && $request->status_id == 5) { // For Validation
            

            $payment_details = array_map(function($id, $name, $ref_no, $amount) {
                return [
                    'id' => $id,
                    'name' => $name,
                    'ref_no' => $ref_no,
                    'amount' => $amount
                ];
            }, $request->hidden_payment_type_ids, $request->hidden_payment_type_name, $request->payment_references, $request->payments);        

            // create record of payment details
            $payment = new Payment();
            $payment->uuid = $sales->uuid;
            $payment->sales_id = $sales->id;
            $payment->payment_type = implode(', ', $request->hidden_payment_type_name); // for easy reading only, actual info is/are in details column 
            $payment->total_amount = $sales->grandtotal_amount;
            $payment->details = json_encode($payment_details);
            $payment->change = str_replace(',', '', $request->cash_change);
            $payment->created_by = Auth::user()->name;
            $payment->updated_by = Auth::user()->name;
            $payment->save();


            // update the sales table [parent]
            $sales->status_id = $request->status_id;
            $sales->payment_id = $payment->id; // now, lets create the relationship that is not defined in the create_sales_table migration;
            $sales->si_no = str_replace("SO", "SI", $sales->so_no);
            $sales->si_assignment_id = $request->si_assignment_id;


            if($sales->update()) {
                // update the sales invoice assignment details
                $si_assignment = SalesInvoiceAssignmentDetail::whereId($request->si_assignment_id)->first();
                $si_assignment->used = 1;
                $si_assignment->so_no = $sales->so_no;
                $si_assignment->si_no = $sales->si_no;
                $si_assignment->update();

                // pass the message to user if the update is successful
                $message = $sales->so_no . ' payment submitted!';
            }

            Helper::transaction_history($sales->id, $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Invoice', 'Submit Payment', $sales->so_remarks);

            // redirect to index page with dynamic message coming from different statuses
            return redirect('sales-invoice/for-invoice')->with(['success' => $message, 'uuid' => $uuid]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sales_invoice_list() 
    {
        $sales_invoice = Sales::with('status','transaction_type')->whereIn('status_id', [2])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice)->toJson(); 
    }

    public function print($uuid) 
    {
        //sleep(3); // allow x seconds interval before getting the sales details

        $sales_order = Sales::whereUuid($uuid)
                        ->whereStatusId(5)
                        ->with('transaction_type')
                        ->with('sales_details', function($query) {
                            $query->where('deleted',0);
                        })->firstOrFail();
        
        return view('SalesInvoice.print.show', compact('sales_order'));
    }
}
