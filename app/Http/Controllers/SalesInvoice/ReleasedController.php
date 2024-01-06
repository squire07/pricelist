<?php

namespace App\Http\Controllers\SalesInvoice;

use App\Models\Sales;
use App\Models\History;
use App\Models\SalesInvoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReleasedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get current users branch ids 
        $user_branch = User::whereId(Auth::user()->id)->value('branch_id');

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
                            ->whereStatusId(4)
                            ->whereDeleted(false)
                            ->when(!empty($user_branch), function($query) use ($user_branch) {
                                $query->whereIn('branch_id', explode(',',$user_branch));
                            })
                            ->orderByDesc('id')
                            ->get();

        return view('SalesInvoice.released.index', compact('sales_orders'));    
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
        $sales_order = Sales::with('payment','transaction_type','income_expense_account')
                        ->whereUuid($uuid)
                        ->whereStatusId(4)
                        ->with(['income_expense_account' => function($query) use ($uuid) {

                            // Fetch the sales order inside the closure
                            $sales_order = Sales::whereUuid($uuid)->firstOrFail();

                            $query->where('company_id', $sales_order->company_id);
                        }])
                        ->with('sales_details', function($query) {
                            $query->where('deleted',0);
                        })->firstOrFail();

        // convert the details from json_object to array object
        if(isset($sales_order->payment->details)) {
            $sales_order->payment->details = json_decode($sales_order->payment->details,true);
        }

        $histories = History::whereUuid($sales_order->uuid)->whereDeleted(false)->get();
        
        return view('SalesInvoice.released.show', compact('sales_order','histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoice $salesInvoice)
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

        // check if request contains status_id = 5
        if(isset($request->status_id) && $request->status_id == 4) { // Released
            $sales->status_id = 4; // mark as released
            $sales->update();

            // post to PRIME here



            Helper::transaction_history($sales->id,  $sales->uuid, $sales->transaction_type_id, $sales->status_id, $sales->so_no, 'Sales Invoice', 'Released', $sales->si_remarks);
        }

        // redirect to index page with dynamic message coming from different statuses
        return redirect('sales-invoice/released')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoice $salesInvoice)
    {
        //
    }

    public function sales_invoice_released_list() 
    {
        $sales_invoice_released = Sales::with('status','transaction_type')->whereIn('status_id', [4])->whereDeleted(false)->orderByDesc('id');
        return DataTables::of($sales_invoice_released)->toJson(); 
    }
}
