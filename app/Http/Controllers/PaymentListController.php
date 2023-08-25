<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Auth;
use App\Models\PaymentList;
use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Database\Seeders\PaymentListSeeder;
use Yajra\DataTables\Facades\DataTables;

class PaymentListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = PaymentList::with('status')->whereDeleted(false)->get();
        $companies = Company::whereDeleted(false)->get(['id','name']);
        return view('PaymentType.index',compact('payments','companies'));
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
        $exist = PaymentList::whereName($request->name)->whereDeleted(false)->first();
        if(!$exist) {
            $payment_type = new PaymentList();
            $payment_type->uuid = Str::uuid();
            $payment_type->company_id = $request->company_id;
            $payment_type->name = $request->name;
            $payment_type->code = $request->code;
            $payment_type->status_id = 6; // default to draft ?
            $payment_type->created_by = Auth::user()->name;
            $payment_type->save();
            return redirect('payment-types')->with('success','Payment Type Saved!');
        } else {
            return redirect('payment-types')->with('error', 'Payment Type already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentList $paymentList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentList $paymentList, string $uuid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $payment_type = PaymentList::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $payment_type->company_id = $request->company_id;
        $payment_type->name = $request->name;
        $payment_type->code = $request->code;
        $payment_type->status_id = $request->status ?? 6; // set default to enabled
        $payment_type->remarks = $request->remarks;
        $payment_type->updated_at = Carbon::now();
        $payment_type->updated_by = Auth::user()->name;
        $payment_type->update();

        return redirect('payment-types')->with('success','Payment Type Updated!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $payment_type = PaymentList::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $payment_type->deleted = 1; // boolean 1 = true
        $payment_type->deleted_at = Carbon::now();
        $payment_type->deleted_by = Auth::user()->name;
        $payment_type->update();

        return redirect('payment-types')->with('success', $payment_type->name . ' Payment Type has been deleted!');
    }

    // public function payment_types_list() 
    // {
    //     $payment_types = PaymentList::with('status', 'company')->whereDeleted(false);
    //     return DataTables::of($payment_types)->toJson();
    // }
}
