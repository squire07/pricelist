<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;

class BranchController extends Controller
// {
//     public function get_branches_by_cashiers_id($id) {

//         $user = User::whereDeleted(false)->whereId($id)->first();

//         $explode = explode(',', $user->branch_id);

//         $cashiers_branches = Branch::whereDeleted(false)
//                                 ->whereIn('id', $explode)
//                                 ->get();

//         return $cashiers_branches;        
//     }    
// }

{
    public function get_branches_by_cashiers_id($id) {

        $user = User::whereDeleted(false)->whereId($id)->first();

        $explode = explode(',', $user->branch_id);

        $cashiers_branches = Branch::whereDeleted(false)
                                ->whereIn('id', $explode)
                                ->get();

        // Add status information to each branch
        $branches_with_status = $cashiers_branches->map(function ($branch) {
            return [
                'id' => $branch->id,
                'name' => $branch->name,
                'company_status' => $branch->company->status_id,
                'branch_status' => $branch->status_id,
            ];
        });

        return $branches_with_status;        
    }    
}