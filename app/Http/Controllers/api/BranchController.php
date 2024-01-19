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

        $cashier = User::whereId($cashier_id)->first();

        $explode = explode(',', $cashier->branch_id);

        // authenticated user
        $auth_user = User::whereDeleted(false)->whereId($auth_user_id)->first();
        $auth_branch_ids = explode(',', $auth_user->branch_id);

        if($auth_user->branch_id != null) {
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
        } else {
            $cashiers_branches = Branch::join('companies', 'companies.id', '=', 'branches.company_id')
                                    ->where('companies.status_id', 8)
                                    ->where('branches.deleted', false) 
                                    ->where('branches.status_id', 8) 
                                    ->whereIn('branches.id', explode(',', $cashier->branch_id))
                                    ->get(['branches.*']);
        }
        return $cashiers_branches;        
    }    
}