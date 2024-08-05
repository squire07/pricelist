<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliveries extends Model
{
    use HasFactory;
    public function delivery_details()
    {
        return $this->hasMany('App\Models\DeliveryDetails', 'delivery_id', 'id');
    }

    public function customers()
    {
        return $this->belongsTo('App\Models\Customers', 'name', 'store_name');
    }

    public function deliverystatus()
    {
        return $this->belongsTo('App\Models\DeliveryStatus', 'delivery_status', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function paymentstatus()
    {
        return $this->belongsTo('App\Models\PaymentStatus', 'payment_status', 'id');
    }


    public function agents()
    {
        return $this->belongsTo('App\Models\Employees', 'agents', 'id');
    }

    public function delivered_by()
    {
        return $this->belongsTo('App\Models\Employees', 'delivered_by', 'id');
    }

    public function payment_terms()
    {
        return $this->belongsTo('App\Models\PaymentTerms', 'payment_terms', 'id');
    }

    public function gettotalAmountsAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'delivery_id', 'id');
    }


}
