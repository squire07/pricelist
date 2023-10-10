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
        // $sdf = '48-1-1-1';
        // $explode = explode('-', $sdf);
        // dump($explode);

        // // get user by id
        // $permission = UserPermission::whereUserId($explode[0])->first();
        // dump($permission);

        // // get the user's permission
        // // Decode JSON into a PHP associative array
        // $data = json_decode($permission->user_permission, true);
        // dump($data);

        // dump($data[$explode[1]]);
        // dump($data[$explode[1]][$explode[2]]);
        // dump($data[$explode[1]][$explode[2]] == 0);

        // if (isset($data[$explode[1]]) && isset($data[$explode[1]][$explode[2]])) {
            
        //     $data[$explode[1]][$explode[2]] = ($data[$explode[1]][$explode[2]] == 1) ? 0 : 1;

        //     // save the json_data
        //     $permission->user_permission = json_encode($data);
        //     $permission->update();

        //     return json_encode(['message'=>'updated']);
        // } else {
        //     return json_encode(['message'=>'error']);
        // }

        // dd('stop');


        $user = User::with('permission')->whereUuid($uuid)->first();
        $modules = PermissionModule::whereDeleted(false)->get();
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
