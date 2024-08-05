<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Products;
use App\Models\Customers;
use App\Models\Employees;
use App\Models\Deliveries;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\DeliveryStatus;
use Illuminate\Support\Carbon;
use App\Models\PaymentsDelivery;
use Illuminate\Support\Facades\Auth;

class PaymentsDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $deliveries = Deliveries::with('delivery_details','customers','deliverystatus','paymentstatus','agents')
            ->where(function ($query) use ($request) {
                if ($request->has('daterange')) {
                    $date = explode(' - ', $request->daterange);
                    $from = date('Y-m-d', strtotime($date[0])) . ' 00:00:00';
                    $to = date('Y-m-d', strtotime($date[1])) . ' 23:59:59';
        
                    // Apply the whereBetween condition
                    $query->whereBetween('created_at', [$from, $to]);
                }
            })
            ->whereIn('delivery_status', [2,3])
            ->whereDeleted(false)
            ->orderByDesc('id')
            ->get();

        $delivery_status = DeliveryStatus::whereDeleted(false)->get();

        $payment_status = PaymentStatus::whereDeleted(false)->get();

        $drivers = Employees::where('role_id', 4)->whereDeleted(false)->get();

        $agents = Employees::where('role_id', 5)->whereDeleted(false)->get();

        $customers = Customers::with('area_groups','customer_categories')->whereDeleted(false)->whereStatus(1)->get();

        $products = Products::whereDeleted(false)->whereStatus(1)->get();

        return view('payment.delivery.index',compact('deliveries','delivery_status', 'payment_status', 'drivers', 'customers', 'agents', 'products'));
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
    public function show($uuid)
    {
        $delivery = Deliveries::whereUuid($uuid)
                            ->with('delivered_by','status','deliverystatus')
                            ->with('delivery_details', function($query) {
                                $query->where('deleted',0);
                            })
                            ->firstOrFail();

        //$histories = History::whereUuid($delivery->uuid)->whereDeleted(false)->get();
        
        return view('payment.delivery.show', compact('delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentsDelivery $paymentsDelivery, $uuid)
    {
        $delivery = Deliveries::whereUuid($uuid)
                            ->with('delivered_by','status','deliverystatus')
                            ->with('delivery_details', function($query) {
                                $query->where('deleted',0);
                            })
                            ->firstOrFail();

        $payment_types = PaymentMethod::whereDeleted(false)
                    ->where('active', 1)
                    ->orderBy('name')
                    ->get();

        //$histories = History::whereUuid($delivery->uuid)->whereDeleted(false)->get();
        
        return view('payment.delivery.edit', compact('delivery','payment_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {

        //dd($request);
        // Ensure $uuid is taken from request if available
        $uuid = $request->uuid ?? $uuid;
    
        // Retrieve the delivery record
        $deliveries = Deliveries::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
    
        // Check if the version matches the request version
        if ($deliveries->version == $request->version) {
            // Handle delivery cancellation if requested
            if (isset($request->delivery_status) && $request->delivery_status == 3) {
                // Update delivery status to cancelled
                $deliveries->delivery_status = $request->delivery_status;
                $deliveries->delivery_remarks = $request->delivery_remarks;
                $deliveries->updated_by = Auth::user()->name;
                $deliveries->version = $deliveries->version + 1;
    
                if ($deliveries->update()) {
                    $message = $deliveries->dr_no . ' successfully cancelled!';
                    return redirect('payments/delivery')->with(['success' => $message]);
                } else {
                    return redirect('payments/delivery')->with('error', 'Failed to cancel delivery.');
                }
            }
    
            // Create and save a new Payment record
            $payment = new Payment();
            $payment->uuid = $deliveries->uuid;
            $payment->delivery_id = $deliveries->id;
            $payment->payment_origin = 1;
            $payment->payment_type = implode(', ', $request->hidden_payment_type_name);
            $payment->total_amount = $deliveries->grandtotal_amount;
            $payment->change = str_replace(',', '', $request->cash_change);
            $payment->amount_paid = str_replace(',', '', $request->amount_paid);
            $payment->total_amount_paid = str_replace(',', '', $request->amount_paid);
            $payment->balance = str_replace(',', '', $request->balance);
            $payment->payment_references = $request->payment_references;
            $payment->created_by = Auth::user()->name;
            $payment->updated_by = Auth::user()->name;
            $payment->save();
    
            // Update deliveries table
            $deliveries->version = $deliveries->version + 1;
            $deliveries->payment_id = $payment->id;
            $deliveries->payment_remarks = $request->payment_remarks; // Update payment remarks if needed
            $deliveries->updated_by = Auth::user()->name;
            $deliveries->paid_at = Carbon::now()->toDateTimeString();

            // Determine payment status based on balance
            if ($payment->balance != 0) {
                $deliveries->payment_status = 4; // Set payment_status to "Balance Remaining"
            } else {
                $deliveries->payment_status = 2; // Set payment_status to "Fully Paid"
            }

            if ($deliveries->update()) {
                return redirect('payments/delivery')->with(['success' => $deliveries->dr_no . ' payment submitted!', 'uuid' => $uuid]);
            } else {
                return redirect('payments/delivery')->with('error', 'Failed to update deliveries record.');
            }
        }
    }
    
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentsDelivery $paymentsDelivery)
    {
        //
    }

    public function editPayment($uuid)
    {
        $payments = Payment::where('uuid', $uuid)->firstOrFail();

        $delivery = Deliveries::whereUuid($uuid)
                ->with('delivered_by','status','deliverystatus')
                ->with('delivery_details', function($query) {
                    $query->where('deleted',0);
                })
                ->firstOrFail();

        $payment_types = PaymentMethod::whereDeleted(false)
                ->where('active', 1)
                ->orderBy('name')
                ->get();

        return view('payment.delivery.edit-payment', compact('payments','delivery', 'payment_types'));
    }

    public function updatePayment(Request $request, $uuid)
    {
        //dd($request);
        // Ensure $uuid is taken from request if available
        $uuid = $request->uuid ?? $uuid;
    
        // Retrieve the delivery record
        $deliveries = Deliveries::whereUuid($uuid)->whereDeleted(false)->firstOrFail();
    
        // Check if the version matches the request version
        if ($deliveries->version == $request->version) {
            // Handle delivery cancellation if requested
            if (isset($request->delivery_status) && $request->delivery_status == 3) {
                // Update delivery status to cancelled
                $deliveries->delivery_status = $request->delivery_status;
                $deliveries->delivery_remarks = $request->delivery_remarks;
                $deliveries->updated_by = Auth::user()->name;
                $deliveries->version = $deliveries->version + 1;
    
                if ($deliveries->update()) {
                    $message = $deliveries->dr_no . ' successfully cancelled!';
                    return redirect('payments/delivery')->with(['success' => $message]);
                } else {
                    return redirect('payments/delivery')->with('error', 'Failed to cancel delivery.');
                }
            }
    
            // Create and save a new Payment record
            $payment = Payment::where('uuid', $uuid)->firstOrFail();

            // Retrieve existing payment types and combine with new ones
            $existingPaymentTypes = $payment->payment_type ?: ''; // Get existing payment types or initialize as empty string
            $newPaymentTypes = implode(', ', $request->hidden_payment_type_name);

            // Concatenate existing payment types with new payment types
            $payment->payment_type = $existingPaymentTypes ? $existingPaymentTypes . ' / ' . $newPaymentTypes : $newPaymentTypes;

            // Retrieve existing payment references and combine with new ones
            $existingPaymentReferences = $payment->payment_references ?: ''; // Get existing payment references or initialize as empty string
            $newPaymentReferences = $request->payment_references; // Assuming payment_references is an array or a string

            // Concatenate existing payment references with new payment references
            $payment->payment_references = $existingPaymentReferences ? $existingPaymentReferences . ' / ' . $newPaymentReferences : $newPaymentReferences;

            $payment->total_amount = $deliveries->grandtotal_amount;
            $payment->change = str_replace(',', '', $request->cash_change);
            $payment->amount_paid = str_replace(',', '', $request->amount_paid);
            $payment->total_amount_paid = str_replace(',', '', $request->total_amount_paid);
            $payment->balance = str_replace(',', '', $request->balance);
            $payment->created_by = Auth::user()->name;
            $payment->updated_by = Auth::user()->name;
            $payment->save();
    
            // Update deliveries table
            $deliveries->version = $deliveries->version + 1;
            $deliveries->payment_status = 4; // Set payment_status to "Balance Remaining"
            $deliveries->payment_remarks = $request->payment_remarks; // Update payment remarks if needed
            $deliveries->updated_by = Auth::user()->name;
            $deliveries->paid_at = Carbon::now()->toDateTimeString();

            if ($payment->balance != 0) {
                $deliveries->payment_status = 4; // Set payment_status to "Balance Remaining"
            } else {
                $deliveries->payment_status = 2; // Set payment_status to "Fully Paid"
            }
    
            if ($deliveries->update()) {
                return redirect('payments/delivery')->with(['success' => $deliveries->dr_no . ' payment submitted!', 'uuid' => $uuid]);
            } else {
                return redirect('payments/delivery')->with('error', 'Failed to update deliveries record.');
            }
        } else {
            return redirect('payments/delivery')->with('error', 'This record was recently modified by another user!');
        }
    }
}
