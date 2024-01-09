<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Sales;
use App\Models\Branch;
use App\Models\StockCard;
use App\Models\SalesDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class StockCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // get current users branch ids 
        $user_branch = User::whereId(Auth::user()->id)->value('branch_id');

        $sales = Sales::with('sales_details', 'transaction_type', 'branch')
            ->where(function ($query) use ($request) {
                if ($request->has('daterange')) {
                    $date = explode(' - ', $request->daterange);
                    $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                    $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';

                    // Apply the whereBetween condition
                    $query->whereBetween('created_at', [$from, $to]);
                }
                if ($request->has('branch')) {
                    $query->where('branch_id', $request->input('branch'));
                }   
                else if ($request->has('item')) {
                    $query->whereRelation('sales_details', function($query) use ($request) {
                        $query->where('item_code', $request->input('item'));
                    });
                } 
                else if ($request->has('bcid')) {
                    $query->where('bcid', $request->input('bcid'));
                } 
                else if ($request->has('transaction_type')) {
                    $query->where('transaction_type_id', $request->input('transaction_type'));
                }              
            })
            ->whereIn('status_id', [4, 5])
            ->where('deleted', 0)
            ->when(!empty($user_branch), function ($query) use ($user_branch) {
                $query->whereIn('branch_id', explode(',', $user_branch));
            })
            ->get();

        $branches = Branch::whereDeleted(false)->get();

        $transaction_types = TransactionType::whereDeleted(false)->get();

        $items = Item::whereDeleted(false)->get();

        return view('stockcard.index', compact('sales', 'branches', 'transaction_types', 'items'));
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
    public function show(StockCard $stockCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockCard $stockCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockCard $stockCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockCard $stockCard)
    {
        //
    }

    public function stockcard_list() 
    {
        $stockcards = Sales::whereDeleted(false);
        return DataTables::of($stockcards)->toJson();
    }

}
