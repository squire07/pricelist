<?php

namespace App\Http\Controllers;

use App\Models\Branch;
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
        $branches = Branch::with('status')->whereDeleted(false)->get();
        // dd($branches);
        return view('branch.index',compact('branches'));
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
        $existName = Branch::whereName($request->name)->whereCode($request->code)->whereCostCenter($request->cost_center)->whereDeleted(false)->first();
        $existNameCode = Branch::whereName($request->name)->whereCode($request->code)->whereDeleted(false)->first();
        $existNameCodeCenter = Branch::whereName($request->name)->whereCode($request->code)->whereCostCenter($request->cost_center)->whereDeleted(false)->first();
        if(!$existName || $existNameCode || $existNameCodeCenter) {
            $branch = new Branch();
            $branch->uuid = Str::uuid();
            $branch->name = $request->name;
            $branch->code = $request->code;
            $branch->cost_center = $request->cost_center;
            $branch->status_id = 8; //set default status to Active
            $branch->created_by = Auth::user()->name;
            $branch->save();
            return redirect()->back()->with('success', 'Branch has been created!');
        } else {
            return redirect()->back()->with('error', 'Branch already exists!');
        }
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
        $branch = Branch::whereUuid($uuid)->whereDeleted(false)->firstOrFail();

        // check first if branch name and code exist
        $existName = Branch::whereName($request->name)->whereDeleted(false)->first();
        $existNameCode = Branch::whereName($request->name)->whereCode($request->code)->whereDeleted(false)->first();
        $existNameCodeCenter = Branch::whereName($request->name)->whereCode($request->code)->whereCostCenter($request->cost_center)->whereDeleted(false)->first();

        if(!$existName || !$existNameCode || !$existNameCodeCenter) {
            $branch->name = $request->name;     
            $branch->code = $request->code;
            $branch->cost_center = $request->cost_center;
            $branch->status_id = $request->status;
            $branch->remarks = $request->remarks;
            $branch->updated_by = Auth::user()->name;
            $branch->update();
            $msg = 'Branch has been updated!';
            $msgType = 'success';
        } else {
            $msg = 'Branch name and code already exist';
            $msgType = 'error';
        }
        return redirect('branches')->with($msgType, $msg);

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
