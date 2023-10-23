<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Auth;

class TransactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction_types = TransactionType::whereDeleted(false)->get();
        return view('TransactionType.index', compact('transaction_types'));
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
    public function show(TransactionType $transactionType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionType $transactionType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionType $transactionType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionType $transactionType)
    {
        //
    }

    // this should be moved at api
    public function sync_transaction_type() {

        // ERPNext 
        $param = '/api/resource/Price List?limit=500&filters=[["selling","=","1"]]';
        $data = Helper::get_erpnext_data($param);

        // to refactor soon
        DB::table('transaction_types')->truncate();

        foreach($data['data'] as $key => $price_lists){
            // create 
            $transaction_type = new TransactionType();
            $transaction_type->uuid = Str::uuid();
            $transaction_type->name = $price_lists['name'];
            $transaction_type->created_by = Auth::user()->name;
            $transaction_type->updated_by = Auth::user()->name;
            $transaction_type->save();
        }
        return true;
    }
}
