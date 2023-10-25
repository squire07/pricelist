<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    // relationships



    // getters  
    public function getCreatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }


    // setters
    public function setTotalAmountAttribute($value)
    {
        $this->attributes['total_amount'] = str_replace(',', '', $value);
    }

    public function setChangeAttribute($value)
    {
        $this->attributes['change'] = str_replace(',', '', $value);
    }
}
