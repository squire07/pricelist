<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('status')->whereDeleted(false)->get();
        $branches = Branch::with('status')->whereDeleted(false)->get();
        // dd($branches);
        return view('branch.index',compact('branches','companies'));
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
        // Check for duplicate values in name
        $duplicateNameCount = Branch::where('name', $request->name)->where('deleted', false)->count();
    
        if ($duplicateNameCount > 0) {
            return redirect()->back()->with('error', 'Duplicate Entry: Branch Name already exists')->withInput($request->except('name'));
        }
    
        // Check for duplicate values in code and cost_center linked to the company
        $duplicateCodeCount = Branch::where('code', $request->code)
            ->where('company_id', $request->company_id)
            ->where('deleted', false)
            ->count();
    
        if ($duplicateCodeCount > 0) {
            return redirect()->back()->with('error', 'Duplicate Entry: Branch Code already exists for this company!')->withInput($request->except('code'));
        }
    
        $duplicatesCostCenterCount = Branch::where('cost_center', $request->cost_center)
            ->where('company_id', $request->company_id)
            ->where('deleted', false)
            ->count();
    
        if ($duplicatesCostCenterCount > 0) {
            return redirect()->back()->with('error', 'Duplicate Entry: Cost Center already exists for this company!')->withInput($request->except('cost_center'));
        }   
        // Check for duplicate values in warehouse
        $duplicateWarehouseCount = Branch::where('warehouse', $request->warehouse)->where('deleted', false)->count();
    
        if ($duplicateWarehouseCount > 0) {
            return redirect()->back()->with('error', 'Duplicate Entry: Warehouse already exists!')->withInput($request->except('warehouse'));
        }
    
        $branch = new Branch();
        $branch->uuid = Str::uuid();
        $branch->name = $request->name;
        $branch->code = $request->code;
        $branch->company_id = $request->company_id;
        $branch->cost_center = $request->cost_center;
        $branch->cost_center_name = $request->cost_center_name;
        $branch->warehouse = $request->warehouse;
        $branch->status_id = 8; // Set default status to Active
        $branch->created_by = Auth::user()->name;
        $branch->save();
    
        return redirect()->back()->with('success', 'Branch has been created!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $branch = Branch::where('uuid', $uuid)->firstOrFail();
    
        // Update fields if status is the only change
        if ($request->filled('status') && count($request->all()) === 1) {
            $branch->status_id = $request->status;
            $branch->remarks = $request->remarks;
        } else {
            // Check for duplicate values in specified fields
            $duplicateFields = ['name', 'cost_center_name', 'warehouse'];
    
            foreach ($duplicateFields as $field) {
                if ($request->filled($field) && $branch->$field !== $request->$field) {
                    $duplicateCount = Branch::where($field, $request->$field)
                        ->where('company_id', $request->company_id)
                        ->where('deleted', false)
                        ->where('uuid', '<>', $uuid)
                        ->count();
    
                    if ($duplicateCount > 0) {
                        return redirect()->back()->with('error', 'Duplicate Entry: ' . $field . ' already exists for this company!')
                            ->withInput($request->except($field));
                    }
    
                    $branch->$field = $request->$field;
                }
            }
    
            // Check for duplicate values in warehouse if it is set and different from the current value
            if ($request->filled('warehouse') && $branch->warehouse !== $request->warehouse) {
                $duplicateWarehouseCount = Branch::where('warehouse', $request->warehouse)
                    ->where('company_id', $request->company_id)
                    ->where('deleted', false)
                    ->where('uuid', '<>', $uuid)
                    ->count();
    
                if ($duplicateWarehouseCount > 0) {
                    return redirect()->back()->with('error', 'Duplicate Entry: Warehouse already exists for this company!')
                        ->withInput($request->except('warehouse'));
                }
    
                $branch->warehouse = $request->warehouse;
            }
    
            // Check for duplicate values in code and cost_center linked to the company_id
            $duplicateCodeCount = Branch::where('code', $request->code)
                ->where('company_id', $request->company_id)
                ->where('deleted', false)
                ->where('uuid', '<>', $uuid)
                ->count();
    
            $duplicateCostCenterCount = Branch::where('cost_center', $request->cost_center)
                ->where('company_id', $request->company_id)
                ->where('deleted', false)
                ->where('uuid', '<>', $uuid)
                ->count();
    
            if ($duplicateCodeCount > 0) {
                return redirect()->back()->with('error', 'Duplicate Entry: Code already exists for this company');
            }
    
            if ($duplicateCostCenterCount > 0) {
                return redirect()->back()->with('error', 'Duplicate Entry: Cost Center already exists for this company');
            }
            // Update code and cost_center fields
            $branch->code = $request->code;
            $branch->cost_center = $request->cost_center;
        }
        // // Check if company_id is present in the request before updating
        // if ($request->has('company_id')) {
        //     $branch->company_id = $request->company_id;
        // }
        // Update other fields along with the status
        $branch->status_id = $request->status;
        $branch->remarks = $request->remarks;
        $branch->updated_by = Auth::user()->name;
        $branch->update();
    
        return redirect()->back()->with('success', 'Branch has been updated!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $branch = Branch::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $branch->deleted = 1; // boolean 1 = true
        $branch->deleted_at = Carbon::now();
        $branch->deleted_by = Auth::user()->name;
        $branch->update();

        return redirect('branches')->with('success', $branch->name . ' branch has been deleted!');
    }
}
