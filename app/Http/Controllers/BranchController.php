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
            return redirect()->back()->with('error', 'Duplicate value in Branch name!')->withInput($request->except('name'));
        }

        // Check for duplicate values in code
        $duplicateCodeCount = Branch::where('code', $request->code)->where('deleted', false)->count();

        if ($duplicateCodeCount >= 2) {
            return redirect()->back()->with('error', 'Cannot create more than two branches with the same code!');
        }

        // Check if there are already two branches with the same cost_center
        $duplicatesCostCenterCount = Branch::where('cost_center', $request->cost_center)->where('deleted', false)->count();

        if ($duplicatesCostCenterCount >= 2) {
            return redirect()->back()->with('error', 'Cannot create more than two branches with the same cost center!');
        }

        // Check for duplicate values in cost_center_name
        $duplicateCostCenterNameCount = Branch::where('cost_center_name', $request->cost_center_name)->where('deleted', false)->count();

        if ($duplicateCostCenterNameCount > 0) {
            return redirect()->back()->with('error', 'Duplicate value in cost center name!')->withInput($request->except('cost_center_name'));
        }

        // Check for duplicate values in warehouse
        $duplicateWarehouseCount = Branch::where('warehouse', $request->warehouse)->where('deleted', false)->count();

        if ($duplicateWarehouseCount > 0) {
            return redirect()->back()->with('error', 'Duplicate value in Warehouse!')->withInput($request->except('warehouse'));
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
    
        // Check if only the status is being updated
        if ($request->filled('status') && count($request->all()) === 1) {
            // Update only the status field
            $branch->status_id = $request->status;
            $branch->remarks = $request->remarks;
            $branch->updated_by = Auth::user()->name;
            $branch->update();
    
            return redirect()->back()->with('success', 'Branch status has been updated!');
        }
    
        // Check for duplicate values in specified fields
        $duplicateFields = ['name', 'cost_center_name', 'warehouse'];
    
        foreach ($duplicateFields as $field) {
            if ($request->filled($field) && $branch->$field !== $request->$field) {
                $duplicateCount = Branch::where($field, $request->$field)
                    ->where('deleted', false)
                    ->where('uuid', '<>', $uuid)
                    ->count();
    
                if ($duplicateCount > 0) {
                    return redirect()->back()->with('error', 'Duplicate value in ' . $field . '!')
                        ->withInput($request->except($field));
                }
    
                $branch->$field = $request->$field;
            }
        }
    
        // Check for duplicate values in warehouse if it is set and different from the current value
        if ($request->filled('warehouse') && $branch->warehouse !== $request->warehouse) {
            $duplicateWarehouseCount = Branch::where('warehouse', $request->warehouse)
                ->where('deleted', false)
                ->where('uuid', '<>', $uuid)
                ->count();
    
            if ($duplicateWarehouseCount > 0) {
                return redirect()->back()->with('error', 'Duplicate value in Warehouse!')
                    ->withInput($request->except('warehouse'));
            }
    
            $branch->warehouse = $request->warehouse;
        }
    
        // Check for duplicate values in code and cost_center
        $duplicateCodeCount = Branch::where('code', $request->code)
            ->where('deleted', false)
            ->where('uuid', '<>', $uuid)
            ->count();
    
        $duplicateCostCenterCount = Branch::where('cost_center', $request->cost_center)
            ->where('deleted', false)
            ->where('uuid', '<>', $uuid)
            ->count();
    
        // Check if there are less than 2 entries with the same value for code and cost_center
        if ($request->filled('code') && $duplicateCodeCount < 2) {
            $branch->code = $request->code;
        } elseif ($request->filled('code') && $duplicateCodeCount >= 2) {
            return redirect()->back()->with('error', 'Cannot update code due to duplicate values!');
        }
    
        if ($request->filled('cost_center') && $duplicateCostCenterCount < 2) {
            $branch->cost_center = $request->cost_center;
        } elseif ($request->filled('cost_center') && $duplicateCostCenterCount >= 2) {
            return redirect()->back()->with('error', 'Cannot update cost_center due to duplicate values!');
        }
    
        // Update other fields along with the status
        $branch->company_id = $request->company_id;
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
