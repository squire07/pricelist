<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function get_branches_by_cashiers_id($cashier_id, $auth_user_id) {

        // auth will not work under api
        $auth_user = User::whereId($auth_user_id)->first();

        $cashier_user = User::whereId($cashier_id)->first();

        $active_companies = Company::whereStatusId(8)->pluck('id');
        $active_branches = Branch::whereStatusId(8)->pluck('id');

        if(in_array($auth_user->role_id, [11,12])) {
            $final_branches = Branch::whereStatusId(8)
                                ->whereIn('company_id', $active_companies->toArray())
                                ->whereIn('id', explode(',',$cashier_user->branch_id))
                                ->pluck('id');
        } else {
            $auth_user_active_company_ids = array_intersect(explode(',', $auth_user->company_id), $active_companies->toArray());
            $auth_user_branches_by_active_company = Branch::whereIn('company_id', $auth_user_active_company_ids)->pluck('id');

            $final_branches_sp1 = array_intersect($auth_user_branches_by_active_company->toArray(), $active_branches->toArray());
            $final_branches_sp2 = array_intersect($auth_user_branches_by_active_company->toArray(), $final_branches_sp1);

            $final_branches = array_intersect($final_branches_sp2, explode(',', $auth_user->branch_id));
            $final_branches = empty($final_branches) ? [null] : $final_branches;
        }

        $cashiers_branches = Branch::whereDeleted(false)
                                ->where(function ($query) use ($final_branches) {
                                    foreach ($final_branches as $auth_user_branch) {
                                        $query->orWhereRaw("FIND_IN_SET(?, id)", [$auth_user_branch]);
                                    }
                                })
                                ->get();
                                
        return $cashiers_branches;        
    }    
}