<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\TransactionType;
use App\Models\TransactionTypeValidity;
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
        $transaction_types = TransactionType::with('validity')->whereDeleted(false)->get();
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
        $transaction_type = TransactionType::with('validity')
                                ->whereId($transactionType->id)
                                ->firstOrFail();

        $period = !is_null($request->validity_period) ? explode(' - ', $request->validity_period) : null;

        if($transaction_type->validity) {
            // update the validity if exists
            $validity = TransactionTypeValidity::whereDeleted(false)
                            ->whereTransactionTypeId($transaction_type->id)
                            ->first();
            $validity->valid_from = !is_null($period) ? $period[0] : null;
            $validity->valid_to = !is_null($period) ? $period[1] : null;
            $validity->updated_by = Auth::user()->name;
            $validity->update();
        } elseif (!is_null($period)) {
            // save the validity if not null
            $validity = new TransactionTypeValidity;
            $validity->transaction_type_id = $transaction_type->id;
            $validity->valid_from = !is_null($period) ? $period[0] : null;
            $validity->valid_to = !is_null($period) ? $period[1] : null;
            $validity->created_by = Auth::user()->name;
            $validity->save();
        }

        return redirect()->back()->with('success', 'Validity Period Updated!');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transaction_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

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
