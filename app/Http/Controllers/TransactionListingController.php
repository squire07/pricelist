<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sales;
use Illuminate\Http\Request;
use App\Models\TransactionListing;
use Illuminate\Support\Facades\Auth;

class TransactionListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            // get current users branch ids 
        $user_branch = User::whereId(Auth::user()->id)->value('branch_id');
        
        $sales = Sales::with('sales_details','transaction_type','branch','payment','income_expense_account')
                        ->where(function ($query) use ($request) {
                            if ($request->has('daterange')) {
                                $date = explode(' - ', $request->daterange);
                                $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                                $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
                    
                                // Apply the whereBetween condition
                                $query->whereBetween('created_at', [$from, $to]);
                            }
                        })
                            ->whereIn('status_id', [4,5])
                            ->where('deleted', 0)
                            ->when(!empty($user_branch), function($query) use ($user_branch) {
                                $query->whereIn('branch_id', explode(',',$user_branch));
                        })
                        ->get();  
    
        return view('transactionlisting.index', compact('sales'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionListing $transactionListing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionListing $transactionListing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionListing $transactionListing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionListing $transactionListing)
    {
        //
    }
}
