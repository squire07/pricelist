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
        $branches = Branch::whereDeleted(false)->get();
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
        $exist = Branch::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $branch = new Branch();
            $branch->uuid = Str::uuid();
            $branch->name = $request->name;
            $branch->code = $request->code;
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
        $branch->name = $request->name;
        $branch->code = $request->code;
        $branch->updated_by = Auth::user()->name;
        $branch->update();

        return redirect('branches')->with('success', 'Branch has been updated!');
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
