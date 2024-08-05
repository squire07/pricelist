<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Depends;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::whereDeleted(false)->get();
        return view('department.index',compact('departments'));
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
        $exist = Department::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $departments = new Department();
            $departments->uuid = Str::uuid();
            $departments->name = $request->name;
            $departments->created_by = Auth::user()->name;
            $departments->save();
            return redirect()->back()->with('success', 'Department has been created!');
        } else {
            return redirect()->back()->with('error', 'Department already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $department = Department::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        if (Department::where('name', $request->name)->whereNot('uuid', $uuid)->exists()) {
            return redirect()->back()->with('error', "Department already exists!");
        } 

            $department->name = $request->name ?? $department->name;
            $department->updated_by = Auth::user()->name;
            $department->update();

            return redirect()->back()->with('success', 'Department has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
