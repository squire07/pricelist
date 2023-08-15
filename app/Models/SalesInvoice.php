<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    use HasFactory;

    public function payment_type()
    {
        return $this->hasOne('App\Models\PaymentList', 'id', 'payment_lists_id');
    }
}
