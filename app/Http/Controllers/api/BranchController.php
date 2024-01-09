<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function get_branches_by_cashiers_id($cashier_id, $auth_user_id) {

        $user = User::whereDeleted(false)->whereId($cashier_id)->first();

        $explode = explode(',', $user->branch_id);

        // authenticated user
        $auth_user = User::whereDeleted(false)->whereId($auth_user_id)->first();
        $auth_branch_ids = explode(',', $auth_user->branch_id);

        $cashiers_branches = Branch::whereDeleted(false)
                                ->where('status_id', 8) // get only the active; To refactor soon as `status` with boolean data type; 1 = active/true  2 = inactive/false
                                ->where(function($query) use($auth_branch_ids) {
                                    $query->whereIn('id', $auth_branch_ids)
                                        ->orWhere(function ($query) use ($auth_branch_ids) {
                                            foreach ($auth_branch_ids as $auth_branch_id) {
                                                $query->orWhereRaw('FIND_IN_SET(?, id)', [$auth_branch_id]);
                                            }
                                        });
                                })
                                ->get();
        return $cashiers_branches;        
    }    
}