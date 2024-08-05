<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryDetails extends Model
{
    use HasFactory;
    public function deliveries() 
    {
        return $this->belongsTo('App\Models\Deliveries', 'id', 'sales_id');
    }
}
