<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->hasOne('App\Models\TransactionType', 'id', 'transaction_type_id');
    }

    public function getAmountAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getNucAttribute($value)
    {
        return number_format($value,2,'.',',');
    }

    public function getRsPointsAttribute($value)
    {
        return number_format($value,2,'.',',');
    }
}
