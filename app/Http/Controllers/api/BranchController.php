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
                                ->get();

        return $cashiers_branches;        
    }    
}
