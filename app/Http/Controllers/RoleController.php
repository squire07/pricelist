<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Branches;
use Carbon\Carbon;
use Auth;

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
        //
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
