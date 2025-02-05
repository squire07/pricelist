<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Department;
use App\Models\PermissionModule;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPermission;
use Session;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['role','branch','company'])->whereDeleted(false)->get();
        
        $companies = Company::whereDeleted(false)->get(); // 1 does not exists in status table as active/enable

        $company_ids = [];
        foreach($companies as $company) {
            $company_ids[] = $company->id;
        }

        $departments = Department::whereDeleted(false)->get();

        $roles = Role::whereDeleted(false)->whereNotIn('id', [12])->get();
        return view('user.index', compact('users','departments','companies','roles'));
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
        if (User::where('username', $request->username)->exists()) {
            return redirect()->back()->with('error', "User with username {$request->username} already exists!");
        }
        
        // Validate company and branch selections
        // $selected_company_id = isset($request->company_id) ? $request->company_id : [];
        // $selected_branch_id = isset($request->branch_id) ? $request->branch_id : [];

        // // Create an array to store selected branches for each company
        // $selected_branched_by_company = [];

        // // Group selected branches by company
        // foreach ($selected_branch_id as $branchId) {
        //     $branch = Branch::find($branchId);
        //     $companyId = $branch->company_id;

        //     if (!isset($selected_branched_by_company[$companyId])) {
        //         $selected_branched_by_company[$companyId] = [];
        //     }

        //     $selected_branched_by_company[$companyId][] = $branchId;
        // }

        // // Check if at least one branch is selected for each company
        // foreach ($selected_company_id as $companyId) {
        //     if (!isset($selected_branched_by_company[$companyId])) {
        //         return redirect()->back()->with('error', "Please select at least one branch for each company!");
        //     }
        // }

        $user = new User();
        $user->uuid = Str::uuid();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->company_id = 1; // Default company id
        $user->branch_id = 1; //Default branch id
        // $user->company_id = isset($request->company_id) ? implode(',', $request->company_id) : '';
        // $user->branch_id = isset($request->branch_id) ? implode(',', $request->branch_id) : '';
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
        // if (User::where('email', $request->email)->whereNot('uuid', $uuid)->exists()) {
        //     return redirect()->back()->with('error', "User with email {$request->email} already exists!");
        // } 
    
        $user = User::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); 
        }

        // Validate company and branch selections
        $selected_company_id = isset($request->company_id) ? $request->company_id : [];
        $selected_branch_ids = isset($request->branch_id) ? $request->branch_id : [];

        // Create an array to store selected branches for each company
        $selected_branched_by_company = [];

        // Group selected branches by company
        foreach ($selected_branch_ids as $branchId) {
            $branch = Branch::find($branchId);
            $companyId = $branch->company_id;

            if (!isset($selected_branched_by_company[$companyId])) {
                $selected_branched_by_company[$companyId] = [];
            }

            $selected_branched_by_company[$companyId][] = $branchId;
        }

        // Check if at least one branch is selected for each company
        foreach ($selected_company_id as $companyId) {
            if (!isset($selected_branched_by_company[$companyId])) {
                // Only return an error if branches are selected for the company
                if (isset($request->branch_id) && in_array($companyId, $request->company_id)) {
                    return redirect()->back()->with('error', "Please select at least one branch for each company!");
                }
            }
        }
        // $user->company_id = isset($request->company_id) ? implode(',', $request->company_id) : '';
        // $user->branch_id = isset($request->branch_id) ? implode(',', $request->branch_id) : $user->branch_id;
        $user->role_id = $request->role_id;
        $user->active = $request->active; 
        $user->blocked = $request->blocked; 
        $user->created_by = Auth::user()->name;
        
        // Always save the user, regardless of whether the update succeeds
        $user->update();
        
        return redirect()->back()->with('success', 'User has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function update_password(Request $request)
    {
        $user = User::whereDeleted(false)->whereId(Auth::user()->id)->first();
        $user->password = Hash::make($request->new_password);
        $user->update();
        Session::forget('default_password');
        return redirect()->back()->with('success', 'Password has been updated.');
    }
}
