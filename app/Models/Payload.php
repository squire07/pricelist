<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payload extends Model
{
    use HasFactory;

    // relationship
    public function sales()
    {
        return $this->hasOne('App\Models\Sales', 'uuid', 'uuid');
    }


    // getter
    public function getDistributorAttribute($value)
    {
        return $value;
    }

    public function getSoAttribute($value)
    {
        return $value;
    }

    public function getSiAttribute($value)
    {
        return $value;
    }

    public function getPaymentAttribute($value)
    {
        return $value;
    }

    public function getDistributorResponseAttribute($value)
    {
        return $value;
    }

    public function getSoResponseBodyAttribute($value)
    {
        return $value;
    }

    public function getSiResponseBodyAttribute($value)
    {
        return $value;
    }

    public function getPaymentResponseBodyAttribute($value)
    {
        return $value;
    }
}
