<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
use Auth;
use App\Models\PermissionModule;
use App\Models\UserPermission;

class GateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    { 
        $route = Route::current(); // Illuminate\Routing\Route
        $name = Route::currentRouteName(); // result: "roles.index"
        $action = Route::currentRouteAction(); // result: "App\Http\Controllers\RoleController@index"


        // Split the string by the "@" symbol
        $parts = explode('@', $action);

        // get the part before the "@" symbol
        $beforeAt = $parts[0];

        // find the position of the last "\" backslash in the remaining part
        $lastBackslashPos = strrpos($beforeAt, '\\');

        // get the substring after the last "\" backslash
        $afterLastBackslash = substr($beforeAt, $lastBackslashPos + 1);

        // get the substring before the "@" symbol
        $beforeAt = substr($beforeAt, 0, $lastBackslashPos);

        // after @ symbol or the method e.g. 1 = index, 2 = create (save), 3 = show (view), 4 = edit (update)
        $afterAt = $parts[1];

        if(in_array($afterAt, ['index','create','show','edit'])) {

            $method = match($afterAt){
                'index' => 1,
                'create' => 2,
                'show' => 3,
                'edit' => 4,
            };

            // get the id of the controller from Permission Modules table
            $module_id = PermissionModule::whereController($afterLastBackslash)->pluck('id')->first();

            // get the user's permission by auth id
            $user_permission = UserPermission::whereId(Auth::user()->id)->pluck('user_permission')->first();

            $permissions = json_decode($user_permission, true);
            if (isset($permissions[$module_id]) && isset($permissions[$module_id][$method]) && $permissions[$module_id][$method] == 0) {
                // show unauthorize page
                return abort(401, 'Unauthorized');
            }
        }

        return $next($request);
    }
}
