<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Models\PermissionModule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['role','branch','company'])->whereDeleted(false)->get();
        
        $companies = Company::whereDeleted(false)->whereIn('status_id', [8,1])->get(); // 1 does not exists in status table as active/enable

        $company_ids = [];
        foreach($companies as $company) {
            $company_ids[] = $company->id;
        }

        $branches = Branch::whereDeleted(false)->whereIn('company_id', $company_ids)->get();

        $roles = Role::whereDeleted(false)->whereNotIn('id', [12])->get();
        return view('user.index', compact('users','branches','companies','roles'));
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
        if (User::where('username', $request->username)->where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', "User with username {$request->username} and email {$request->email} already exists!");
        } else if (User::where('username', $request->username)->exists()) {
            return redirect()->back()->with('error', "User with username {$request->username} already exists!");
        } else if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', "User with email {$request->email} already exists!");
        } 
        
        $user = new User();
        $user->uuid = Str::uuid();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->company_id = isset($request->company_id) ? implode(',', $request->company_id) : '';
        $user->branch_id = isset($request->branch_id) ? implode(',', $request->branch_id) : '';
        $user->role_id = $request->role_id;
        $user->active = 1; //set default status to Active
        $user->created_by = Auth::user()->name;
        if($user->save()) {
        
            // Save each item's details to the sales details table
            $permissions = new UserPermission();
            $permissions->user_id = $user->id;
            $permissions->uuid = $user->uuid;
            $permissions->user_permission = !in_array($user->role_id, [11,12]) ? $this->permissions(0) : $this->permissions(1);
            $permissions->created_by = Auth::user()->name;
            $permissions->updated_by = Auth::user()->name;
            $permissions->save();
        
            return redirect()->back()->with('success', 'User has been created!');
        } else {
            return redirect()->back()->with('error', 'Failed to create user.');
        }
    }

    public function permissions($int) {
        $modules = PermissionModule::whereDeleted(false)->get();
        $permissions = [];
        foreach ($modules as $key => $module) {
            $permissions[$key + 1] = (strtolower($module->type) == 'module') ? array_fill(1, 4, $int) : [1 => $int];
        }
        return json_encode($permissions);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        if (User::where('email', $request->email)->whereNot('uuid', $uuid)->exists()) {
            return redirect()->back()->with('error', "User with email {$request->email} already exists!");
        } 

        $user = User::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $user->name = $request->name;
        $user->email = $request->email;

        if(isset($request->password)) {
            $user->password = Hash::make($request->password); 
        }

        $user->company_id = isset($request->company_id) ? implode(',', $request->company_id) : '';
        $user->branch_id = isset($request->branch_id) ? implode(',', $request->branch_id) : '';
        $user->active = $request->active; 
        $user->blocked = $request->blocked; 
        $user->created_by = Auth::user()->name;
        if($user->update()) {
            return redirect()->back()->with('success', 'User has been updated!');
        } else {
            return redirect()->back()->with('error', 'Failed to update user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
