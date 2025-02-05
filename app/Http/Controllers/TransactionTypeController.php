<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\TransactionType;
use App\Models\TransactionTypeValidity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Auth;
use Illuminate\Support\Facades\Artisan;

class TransactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaction_types = TransactionType::whereDeleted(false)
                                ->with('validity', function($query) {
                                    $query->where('deleted', 0);
                                })
                                ->with('accounts', function($query) {
                                    $query->where('deleted', 0);
                                })->get();
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
    public function sync_transaction_type() 
    {
        // to refactor soon
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transaction_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Artisan::call('db:seed', ['--class' => 'TransactionTypeSeeder',]);
        return true;
    }
}
