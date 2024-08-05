<?php

namespace App\Http\Controllers;

use App\Models\AreaGroups;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AreaGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $area_groups = AreaGroups::whereDeleted(false)->get();
        return view('area_group.index',compact('area_groups'));
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
        $exist = AreaGroups::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $area_groups = new AreaGroups();
            $area_groups->uuid = Str::uuid();
            $area_groups->name = $request->name;
            $area_groups->created_by = Auth::user()->name;
            $area_groups->save();
            return redirect()->back()->with('success', 'Area Group has been created!');
        } else {
            return redirect()->back()->with('error', 'Area Group already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaGroups $areaGroups)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaGroups $areaGroups)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $area_groups = AreaGroups::whereUuid($uuid)->whereDeleted(false)->firstOrFail();

        // check first if AreaGroups name and code exist
        $existName = AreaGroups::whereName($request->name)->whereDeleted(false)->first();

        if(!$existName) {
            $area_groups->name = $request->name;     
            $area_groups->updated_by = Auth::user()->name;
            $area_groups->update();
            $msg = 'Area Group has been updated!';
            $msgType = 'success';
        } else {
            $msg = 'Area Group already exist';
            $msgType = 'error';
        }
        return redirect('area-groups')->with($msgType, $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaGroups $areaGroups)
    {
        //
    }
}
