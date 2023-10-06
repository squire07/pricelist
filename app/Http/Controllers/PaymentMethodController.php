<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Auth;
use App\Models\PaymentMethod;
use App\Models\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables; use App\Models\Branch;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = PaymentMethod::with('status')->whereDeleted(false)->get();
        $companies = Company::whereDeleted(false)->get(['id','name']);
        $branches = Branch::whereDeleted(false)->get(['id','name']);
        return view('payment_method.index',compact('payments','companies','branches'));
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
        $exist = PaymentMethod::whereName($request->name)->orWhere('code',$request->code)->whereDeleted(false)->first();
        if(!$exist) {
            $payment_method = new PaymentMethod();
            $payment_method->uuid = Str::uuid();
            $payment_method->company_id = $request->company_id;
            $payment_method->name = $request->name;
            $payment_method->code = $request->code;
            $payment_method->status_id = 6; // default to draft ?
            $payment_method->is_cash = $request->is_cash ?? 0;
            $payment_method->branch_id = isset($request->branch_id) ? implode(',', $request->branch_id) : '';
            $payment_method->created_by = Auth::user()->name;
            $payment_method->save();
            return redirect('payment-methods')->with('success','Payment Method Saved!');
        } else {
            return redirect('payment-methods')->with('error', 'Payment Method already exists!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod, string $uuid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $payment_method = PaymentMethod::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $payment_method->company_id = $request->company_id;
        $payment_method->name = $request->name;
        $payment_method->code = $request->code;
        $payment_method->status_id = $request->status ?? 6; // set default to enabled
        $payment_method->is_cash = $request->is_cash ?? $payment_method->is_cash;
        $payment_method->branch_id = isset($request->branch_id) ? implode(',', $request->branch_id) : '';
        $payment_method->remarks = $request->remarks;
        $payment_method->updated_at = Carbon::now();
        $payment_method->updated_by = Auth::user()->name;
        $payment_method->update();

        return redirect('payment-methods')->with('success','Payment Method Updated!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $payment_method = PaymentMethod::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
        $payment_method->deleted = 1; // boolean 1 = true
        $payment_method->deleted_at = Carbon::now();
        $payment_method->deleted_by = Auth::user()->name;
        $payment_method->update();

        return redirect('payment-methods')->with('success', $payment_method->name . ' Payment method has been deleted!');
    }
}
