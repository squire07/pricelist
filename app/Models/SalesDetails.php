<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetails extends Model
{
    use HasFactory;

    public function sales() 
    {
        return $this->belongsTo('App\Models\Sales', 'id', 'sales_id');
    }

    public function getAmountAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getNucAttribute($value)
    {
        return number_format($value,2,'.',',');
    }
}
