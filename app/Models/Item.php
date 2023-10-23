<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    
    // relationships
    public function item()
    {
        return $this->hasOne('App\Models\TransactionType', 'id', 'transaction_type_id');
    }

    // getter and setter
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

    public function getCreatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value != null ? Carbon::parse($value)->format('m/d/Y h:i:s A') : '';
    }
}
