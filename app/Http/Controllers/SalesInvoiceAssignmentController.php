<?php

namespace App\Http\Controllers;

use App\Models\SalesInvoiceAssignment;
use App\Models\SalesInvoiceAssignmentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class SalesInvoiceAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * This is supposedly available only for Head Cashier
     */
    public function index()
    {
        $booklets = SalesInvoiceAssignment::with('booklet_details')->whereDeleted(false)->get();

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
        }

        // get all the cashiers
        $cashiers = User::whereRoleId(2)->whereDeleted(false)->whereBlocked(false)->get();

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
        $prefixed = false;
        $prefix_value = '';

        // check if prefix is set
        if(isset($request->checkbox_prefix)) {
            $prefixed = true;
            $prefix_value = 'A';
        } 

        // check if the series exists in SalesInvoiceAssignmentDetail table
        $exists = SalesInvoiceAssignmentDetail::where('series_number', $prefix_value . substr(str_repeat(0, 6).$request->series_from, - 6))
                        ->orWhere('series_number', $prefix_value . substr(str_repeat(0, 6).$request->series_to, - 6))
                        ->get();
 
        if($exists->isNotEmpty()) {
            return redirect()->back()->with('error', 'The series number already exists!'); 
        } else {
            $booklet = new SalesInvoiceAssignment();
            $booklet->uuid = Str::uuid();
            $booklet->user_id = $request->cashier_id;
            $booklet->branch_id = 1; // get the cashier's designated branch
            $booklet->series_from = $request->series_from;
            $booklet->series_to = $request->series_to;
            $booklet->prefixed = $prefixed;
            $booklet->prefix_value = $prefix_value;
            $booklet->count = ($request->series_to - $request->series_from) + 1; // ex: (0003200 - 0003101) = 99 + 1 => 100;
            $booklet->created_by = Auth::user()->name;

            if($booklet->save()) {
                for($i = $request->series_from; $i <= $request->series_to; $i++) {
                    $details = new SalesInvoiceAssignmentDetail();
                    $details->uuid = $booklet->uuid;
                    $details->sales_invoice_assignment_id = $booklet->id;
                    $details->series_number = $prefix_value . substr(str_repeat(0, 6).$i, - 6); // add prefix 0
                    $details->created_by = Auth::user()->name;
                    // updated by and updated at will be assigned to the cashier and when the series was used
                    $details->save();
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
        $series = SalesInvoiceAssignment::with(['booklet_details','cashier'])->whereUuid($uuid)->firstOrFail();

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
