<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Branches;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::whereDeleted(false)->get();
        return view('role.index',compact('roles'));
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
        $exist = Role::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $role = new Role();
            $role->uuid = Str::uuid();
            $role->name = $request->name;
            $role->created_by = Auth::user()->name;
            $role->save();
            return redirect()->back()->with('success', 'Role has been created!');
        } else {
            return redirect()->back()->with('error', 'Role already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $role = role::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $role->name = $request->name;
        $role->updated_by = Auth::user()->name;
        $role->update();

        return redirect('roles')->with('success', 'role has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $role = role::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $role->deleted = 1; // boolean 1 = true
        $role->deleted_at = Carbon::now();
        $role->deleted_by = Auth::user()->name;
        $role->update();

        return redirect('roles')->with('success', $role->name . ' role has been deleted!');
    }
}
