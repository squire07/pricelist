<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Models\Sales;
use App\Helpers\Helper;
use App\Models\History;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\SalesInvoice;
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
        // default to today's date
        $from = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $to = Carbon::now()->format('Y-m-d') . ' 23:59:59';

        if($request->has('daterange')) {
            $date = explode(' - ',$request->daterange);
            $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
            $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
        } 

        $sales_orders = Sales::with('status','transaction_type')
                            ->whereBetween('created_at', [$from, $to])
                            ->whereStatusId(2)
                            ->whereDeleted(false)
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
        $exploded = array_map('trim', explode(',', Auth::user()->branch_id));

        $payment_types = PaymentMethod::whereDeleted(false)->whereStatusId(6);  // where `status id` should be boolean 1 - active/enabled  0 - inactive/disabled 
            if(count($exploded) == 1) {
                if(array_intersect([1, 7, 6, 12], $exploded)) { // 
                    $payment_types->whereRaw('FIND_IN_SET(?, branch_id)', [$exploded]);
                } else if(array_intersect([2,3,4,5], $exploded)) { // Local
                    $payment_types->where('branch_id', 'LO');
                } else if(array_intersect([8,9,10,11], $exploded)) { // Premier
                    $payment_types->where('branch_id', 'PR');
                } 
            } else if(count($exploded) > 1) {
                $payment_types->whereIn('branch_id', ['LO', 'PR']);
            } else {
                $payment_types->where('branch_id', 6);
            }
        $payment_types = $payment_types->get();

        return view('SalesInvoice.for_invoicing.edit', compact('sales_order','payment_types'));
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

            if($sales->update()) {
                // pass the message to user if the update is successful
                $message = $sales->so_no . ' payment submitted!';
            }

            Helper::transaction_history($sales->id, $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Invoice', 'Submit Payment', $sales->so_remarks);
        }
        
        // redirect to index page with dynamic message coming from different statuses
        return redirect('sales-invoice/for-invoice')->with(['success' => $message, 'uuid' => $uuid]);
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
