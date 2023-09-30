<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    use HasFactory;

    public function getParcelRateAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

}
