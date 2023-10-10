<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPermission;

class PermissionController extends Controller
{
    public function user_permission(Request $request) {
        /* 
        * Request => key e.g. 48-1-1-1  (1st-2nd-3rd-4th)
        * where: 1st - id of user
        *        2nd - module id
        *        3rd - ( 1 = index, 2 = create (save), 3 = show (view), 4 = edit (update) )
        *        4th - 1 = checked, 0 = unchecked
        */

        $keys = explode('-', $request->key);

        // get user by id
        $permission = UserPermission::whereUserId($keys[0])->first();

        // get the user's permission
        // Decode JSON into a PHP associative array
        $data = json_decode($permission->user_permission, true);

        // Check if "key 1" and "sub key 1" exist and replace "sub key 1" with 0
        if (isset($data[$keys[1]]) && isset($data[$keys[1]][$keys[2]])) {
            $data[$keys[1]][$keys[2]] = ($data[$keys[1]][$keys[2]] == 1) ? 0 : 1;

            // save the json_data
            $permission->user_permission = json_encode($data);
            $permission->update();

            return json_encode(['message'=>'ok']);
        } else {
            return json_encode(['message'=>'keys not found']);
        }
    }
}
