<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use App\Models\PermissionModule;
use App\Models\User;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // sales order, sales invoice,
        

    //     // index (dashboard), create/save, view, edit/update
    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(UserPermission $userPermission)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPermission $userPermission, $uuid)
    {
        $user = User::with('permission')->whereUuid($uuid)->first();

        $modules = PermissionModule::whereDeleted(false)->orderBy('sequence')->get();

        return view('user_permission.edit', compact('user','modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserPermission $userPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(UserPermission $userPermission)
    // {
    //     //
    // }
}
