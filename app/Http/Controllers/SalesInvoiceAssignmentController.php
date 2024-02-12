<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use App\Models\SalesInvoiceAssignment;
use App\Models\SalesInvoiceAssignmentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SalesInvoiceAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * This is supposedly available only for Head Cashier
     */
    public function index()
    {
        /*  
        *   Who can assign booklets to cashier?
        *   1. Super/admin
        *   2. Head Cashier
        *   3. Branch Manager
        *   4. Office in charge
        */ 

        // get the active companies 
        $active_companies = Company::whereStatusId(8)->pluck('id'); // Must be refactor! status_id to status with boolean datatype: 0 = inactive/false; 1 = active/true;

        // get the active branches
        $active_branches = Branch::whereStatusId(8)->pluck('id'); // Must be refactor! status_id to status with boolean datatype: 0 = inactive/false; 1 = active/true;

        if(in_array(Auth::user()->role_id, [11,12])) {

            $final_branches = Branch::whereStatusId(8)
                                ->whereIn('company_id', $active_companies->toArray())
                                ->pluck('id');

        } else { 
            // find all the active company ids and branch ids in Auth::user() with role_id 4,5 and 6
            $auth_user_active_company_ids = array_intersect(explode(',', Auth::user()->company_id), $active_companies->toArray());

            // get the branches where user's active company is tagged
            $auth_user_branches_by_active_company = Branch::whereIn('company_id', $auth_user_active_company_ids)->pluck('id');

            // intersect $active_branches with $auth_user_branches_by_active_company
            $final_branches_sp1 = array_intersect($auth_user_branches_by_active_company->toArray(), $active_branches->toArray());

            $final_branches_sp2 = array_intersect($auth_user_branches_by_active_company->toArray(), $final_branches_sp1);

            // intesect
            $final_branches = array_intersect($final_branches_sp2, explode(',',Auth::user()->branch_id));
        }

        // Important: to make and empty array if intersect returns null
        $final_branches = empty($final_branches) ? [null] : $final_branches;

        if(in_array(Auth::user()->role_id, [11,12])) {
            $cashiers = User::whereDeleted(false)
                                ->whereActive(true)
                                ->whereBlocked(false)
                                ->whereRoleId(2)
                                ->where(function ($query) use ($final_branches) {
                                    foreach ($final_branches as $auth_user_branch) {
                                        $query->orWhereRaw("FIND_IN_SET(?, branch_id)", [$auth_user_branch]);
                                    }
                                })
                                ->orderBy('name')
                                ->get();
        } else if(in_array(Auth::user()->role_id, [4,5,6])) { // Head Cashier, OIC, BM; additional condition might be added soon
            $cashiers = User::whereDeleted(false)
                                ->whereActive(true)
                                ->whereBlocked(false)
                                ->whereRoleId(2)
                                ->where(function ($query) use ($final_branches) {
                                    foreach ($final_branches as $auth_user_branch) {
                                        $query->orWhereRaw("FIND_IN_SET(?, branch_id)", [$auth_user_branch]);
                                    }
                                })
                                ->orderBy('name')
                                ->get();
        } 

        $booklets = SalesInvoiceAssignment::with('booklet_details')
                        ->whereDeleted(false)
                        ->where(function ($query) use ($cashiers) {
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
        $series_number = [
            substr(str_repeat(0, 6).$request->series_from, - 6), 
            substr(str_repeat(0, 6).$request->series_to, - 6)
        ];

        // fix the issue with branch_id.             ↓ This branch_id could contain multiple ids if the first dropdown user has multiple branch but one of companies which belongs to the branch has been deactivated
        $branch_ids = $request->cashier_branch_id ?? User::whereDeleted(false)->whereId($request->cashier_id)->first()->branch_id;
        
        $branch_id = null;
        if (strpos($branch_ids, ',') !== false) {
            // explode $branch_ids 
            $branch_ids = explode(',', $branch_ids);
            // get only the correct branch_id from active companies and branches
            $active_company_ids = Company::whereStatusId(8)->pluck('id');
            $active_branch_ids = Branch::whereIn('company_id', $active_company_ids)->pluck('id');
            // final 
            $branch_ids = array_intersect($branch_ids, $active_branch_ids->toArray());  
            $branch_id = empty($branch_ids) ? null : reset($branch_ids);
        } else {
            $branch_id = $branch_ids; // this is actually a single branch id only
        }
        
        // get the company id from branch 
        $company_id = Branch::whereId($branch_id)->first();

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

                                // dd($details_branch);

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

        $overall_total_count = $existing_invoice_total_count + $total_request_count;

        if($details->isNotEmpty()) {
            return redirect()->back()->with('error', 'The series number already exists!'); 
        } else {
            $booklet = new SalesInvoiceAssignment();
            $booklet->uuid = Helper::uuid(new SalesInvoiceAssignment);
            $booklet->user_id = $request->cashier_id;
            $booklet->branch_id = $branch_id; 
            $booklet->series_from = $request->series_from; // prefix (leading zero's) automatically added from model's setter
            $booklet->series_to = $request->series_to; // prefix (leading zero's) automatically added from model's setter
            $booklet->count = $total_request_count;
            $booklet->created_by = Auth::user()->name;

            if($booklet->save()) {

                if($total_request_count > $existing_invoice_total_count) {
                    $loop_count = $request->series_from;
                } else {
                    $loop_count = $existing_invoice_total_count + 1;
                }

                for($i = $request->series_from; $i <= $request->series_to; $i++) {

                    // prefix, run once only; IMPORTANT! do not inline;
                    $prefix = Helper::sales_invoice_prefix($loop_count);

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
