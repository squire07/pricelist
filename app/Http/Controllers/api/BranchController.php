<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;

class BranchController extends Controller
{
    public function get_branches_by_cashiers_id($id) {

        $user = User::whereDeleted(false)->whereId($id)->first();

        $explode = explode(',', $user->branch_id);

        $cashiers_branches = Branch::whereDeleted(false)
                                ->whereIn('id', $explode)
                                ->where('status_id', 8) // get only the active; To refactor soon as status with boolean data type; 1 = active/true  2 = inactive/false
                                ->get();
        return $cashiers_branches;        
    }    
}