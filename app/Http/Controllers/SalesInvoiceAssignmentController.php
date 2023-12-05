<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\SalesInvoiceAssignment;
use App\Models\SalesInvoiceAssignmentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class SalesInvoiceAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * This is supposedly available only for Head Cashier
     */
    public function index()
    {
        $cashiers = User::whereDeleted(false)
                        ->whereActive(true)
                        ->whereBlocked(false)
                        ->whereRoleId(2)
                        // ->where(function ($query) {
                        //     foreach (explode(',', Auth::user()->branch_id) as $branch_id) {
                        //         $query->whereRaw('FIND_IN_SET(?, branch_id)', [$branch_id]);
                        //     }
                        // })
                        ->where(function ($query) {
                            if(!in_array(Auth::user()->role_id, [11,12])) {
                                $query->whereBranchId(Auth::user()->branch_id);
                            }
                        })
                        ->get();

        $booklets = SalesInvoiceAssignment::with('booklet_details')
                        ->whereDeleted(false)
                        ->where(function ($query) use ($cashiers) {
                            // foreach($cashiers as $branch_id) {
                            //     $query->whereRaw('FIND_IN_SET(?, branch_id)', [$branch_id]);
                            // }
                            if(!in_array(Auth::user()->role_id, [11,12])) {
                                $query->whereIn('branch_id', explode(',', Auth::user()->branch_id));
                            }
                        })
                        ->get();

        // count the number of used series per booklet
        foreach($booklets as $booklet) {
            // reset the used counter per booklet
            $used_count = 0;
            foreach($booklet->booklet_details as $series) {
                if($series->used == 1) {
                    $used_count++;
                }
            }            
            // add a new element (column) to collection `booklet`; NOT `booklets`
            $booklet['used'] = $used_count;
            $booklet['percentage_used'] = $used_count == 0 ? 0 : round(($used_count / $booklet->count) * 100);
        }


        return view('sales_invoice_assignment.index', compact('booklets','cashiers'));
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
        // $validator = Validator::make($request->all(), [
        //     'branch_id' => 'required|int',
        //     'series_from' => 'required|int',
        //     'series_to' => 'required|int',
        // ]);
    
        // if ($validator->fails()) {
        //     return redirect()->back()->with('error', 'Data Incomplete!');
        // }
    

        $series_number = [
            substr(str_repeat(0, 6).$request->series_from, - 6), 
            substr(str_repeat(0, 6).$request->series_to, - 6)
        ];

        $branch_id = $request->cashier_branch_id ?? User::whereDeleted(false)->whereId($request->cashier_id)->first()->branch_id;

        // checker
        $details = SalesInvoiceAssignment::with('booklet_details')
                        ->whereDeleted(false)
                        ->whereBranchId($branch_id)
                        ->whereHas('booklet_details', function ($query) use ($series_number) {
                            $query->whereIn('series_number', $series_number);
                        })
                        ->get();

        // counter
        $details_branch = SalesInvoiceAssignment::with('booklet_details')
                        ->whereDeleted(false)
                        ->whereBranchId($branch_id)
                        ->get();

        // merge all the results into a single collection so we can count all the invoices
        $merged_details = collect();
        foreach ($details_branch as $booklet_details) {
            $merged_details = $merged_details->merge($booklet_details->booklet_details);
        }

        $existing_invoice_total_count = 0; 
        if($details_branch->isNotEmpty()){
            $existing_invoice_total_count = count($merged_details);
        }


        $total_request_count = intval($request->series_to) - intval($request->series_from) + 1; // ex: (0003200 - 0003101) = 99 + 1 => 100;

        if($details->isNotEmpty()) {
            return redirect()->back()->with('error', 'The series number already exists!'); 
        } else {
            $booklet = new SalesInvoiceAssignment();
            $booklet->uuid = Str::uuid();
            $booklet->user_id = $request->cashier_id;
            $booklet->branch_id = $branch_id; // get the cashier's designated branch
            $booklet->series_from = $request->series_from; // prefix (leading zero's) automatically added from model's setter
            $booklet->series_to = $request->series_to; // prefix (leading zero's) automatically added from model's setter
            $booklet->count = $total_request_count;
            $booklet->created_by = Auth::user()->name;

            if($booklet->save()) {

                $loop_count = 1;

                for($i = $request->series_from; $i <= $request->series_to; $i++) {

                    // prefix, run once only; IMPORTANT! do not inline;
                    $prefix = Helper::sales_invoice_prefix($existing_invoice_total_count + $loop_count);

                    $details = new SalesInvoiceAssignmentDetail();
                    $details->uuid = $booklet->uuid;
                    $details->sales_invoice_assignment_id = $booklet->id;
                    $details->prefixed = is_null($prefix) ? 0 : 1;
                    $details->prefix_value = $prefix;
                    $details->series_number = substr(str_repeat(0, 6).$i, - 6); // add prefix 0
                    $details->created_by = Auth::user()->name;
                    // updated by and updated at will be assigned to the cashier and when the series was used
                    $details->save();

                    $loop_count++;
                }
                return redirect()->back()->with('success', 'Sales invoice booklet has been created!'); 
            }
            return redirect()->back()->with('error', 'Failed to create sales invoice booklet. Please contact the administrator!'); 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $series = SalesInvoiceAssignment::with(['booklet_details','cashier'])
                    ->whereDeleted(false)
                    ->whereUuid($uuid)
                    ->firstOrFail();

        /* add cost center to object; 
        * note: this is for presentation only in the details page
        * e.g. Series Number Column: Format:  Cost Center - Series Number
        *                                       001-000001
        *                                or:    001-A000001
        */    
        $series->cost_center = Branch::whereDeleted(false)
                                    ->whereId($series->branch_id)
                                    ->first()->cost_center;

        $used_count = 0;
        // count the number of used series
        foreach($series->booklet_details as $invoice) {
            if($invoice->used == 1) {
                $used_count++;
            }
            $series['used'] = $used_count;
        }

        return view('sales_invoice_assignment.show', compact('series'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoiceAssignment $salesInvoiceAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesInvoiceAssignment $salesInvoiceAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoiceAssignment $salesInvoiceAssignment)
    {
        //
    }
}
