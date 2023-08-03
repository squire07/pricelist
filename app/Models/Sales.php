<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    public function sales_details()
    {
        return $this->hasMany('App\Models\SalesDetails', 'sales_id', 'id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\Status', 'id', 'status_id');
    }

    public function getTotalAmountAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getTotalNucAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getSoNoAttribute($value)
    {
        return strtoupper($value);
    }

    public function getSiNoAttribute($value)
    {
        return strtoupper($value);
    }
}
