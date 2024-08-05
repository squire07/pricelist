<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryStatus extends Model
{
    use HasFactory;

    public function deliveries()
    {
        return $this->belongsTo('App\Models\Deliveries', 'id', 'delivery_status');
    }
}
